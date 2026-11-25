<?php

namespace Tests\Feature;

use App\Entities\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\PostService;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_publication_commands_refresh_a_warmed_post_listing(): void
    {
        $repository = app(PostRepositoryInterface::class);
        $repository->store($this->postEntity(null, 'Original'), $this->userId(), []);
        $post = $this->postEntity((int) DB::table('posts')->value('id'), 'Original');
        $service = app(PostService::class);

        $this->assertFalse($repository->getPostStatus($post));
        $this->assertSame([], $repository->getTopPosts(3));

        $service->publish($post->getId());
        $this->assertTrue($repository->getPostStatus($post));
        $this->assertCount(1, $repository->getTopPosts(3));

        $service->unpublish($post->getId());
        $this->assertFalse($repository->getPostStatus($post));
        $this->assertSame([], $repository->getTopPosts(3));
    }

    public function test_category_write_failure_rolls_back_post_and_category_changes(): void
    {
        $repository = app(PostRepositoryInterface::class);
        $userId = $this->userId();
        $categoryId = DB::table('categories')->insertGetId(['name' => 'Original category', 'displayname' => 'Original category', 'has_child' => false]);
        $repository->store($this->postEntity(null, 'Original'), $userId, [$categoryId]);
        $postId = (int) DB::table('posts')->value('id');

        DB::unprepared(<<<'SQL'
            CREATE TEMP TRIGGER reject_category_insert BEFORE INSERT ON category_post
            BEGIN
                SELECT RAISE(ABORT, 'category insert failed');
            END
            SQL);

        try {
            $repository->update($this->postEntity($postId, 'Changed'), $userId, $postId, [$categoryId + 1]);
            $this->fail('Expected the category insert to fail.');
        } catch (QueryException) {
            $this->assertDatabaseHas('posts', ['id' => $postId, 'title' => 'Original']);
            $this->assertDatabaseHas('category_post', ['post_id' => $postId, 'category_id' => $categoryId]);
        }
    }

    public function test_admin_lifecycle_commands_are_idempotent_and_preserve_post_data(): void
    {
        $admin = User::findOrFail($this->userId());
        $admin->forceFill(['email_verified_at' => now()])->save();
        $admin->assignRole(Role::findOrCreate('admin', 'web'));
        $repository = app(PostRepositoryInterface::class);
        $repository->store($this->postEntity(null, 'Original'), $admin->id, []);
        $id = (int) DB::table('posts')->value('id');
        $repository->getPostsForSitemap();

        $this->actingAs($admin);
        $this->putJson(route('admin.posts.publish', $id))->assertNoContent();
        $publishedAt = DB::table('posts')->where('id', $id)->value('date_published');

        $this->travel(1)->minute();
        $this->putJson(route('admin.posts.publish', $id))->assertNoContent();
        $this->assertDatabaseHas('posts', ['id' => $id, 'is_published' => true, 'date_published' => $publishedAt]);
        $this->assertCount(1, $repository->getPostsForSitemap());

        $this->putJson(route('admin.posts.archive', $id))->assertNoContent();
        $archivedAt = DB::table('posts')->where('id', $id)->value('archived_at');
        $this->assertNotNull($archivedAt);
        $this->travel(1)->minute();
        $this->putJson(route('admin.posts.archive', $id))->assertNoContent();
        $this->assertDatabaseHas('posts', [
            'id' => $id, 'title' => 'Original', 'archived_at' => $archivedAt, 'is_published' => false,
        ]);
        $this->assertSame([], $repository->getPostsForSitemap());
        $this->assertSame([], $repository->getSuggests([$id]));
        $this->get(route('posts.show', 'repository-test'))->assertNotFound();
        $this->putJson(route('admin.posts.publish', $id))->assertConflict();

        $this->putJson(route('admin.posts.restore', $id))->assertNoContent();
        $this->putJson(route('admin.posts.restore', $id))->assertNoContent();
        $this->assertDatabaseHas('posts', ['id' => $id, 'archived_at' => null, 'is_published' => false]);
        $this->putJson(route('admin.posts.publish', $id))->assertNoContent();
        $this->putJson(route('admin.posts.restore', $id))->assertNoContent();
        $this->assertDatabaseHas('posts', ['id' => $id, 'archived_at' => null, 'is_published' => true]);

        $this->putJson(route('admin.posts.unpublish', $id))->assertNoContent();
        $this->putJson(route('admin.posts.unpublish', $id))->assertNoContent();
        $this->assertDatabaseHas('posts', ['id' => $id, 'is_published' => false, 'date_published' => null]);
    }

    public function test_post_lifecycle_commands_require_an_admin(): void
    {
        $user = User::findOrFail($this->userId());
        app(PostRepositoryInterface::class)->store($this->postEntity(null, 'Original'), $user->id, []);
        $id = (int) DB::table('posts')->value('id');

        $this->putJson(route('admin.posts.publish', $id))->assertUnauthorized();
        $this->actingAs($user);
        foreach (['publish', 'unpublish', 'archive', 'restore'] as $action) {
            $this->putJson(route('admin.posts.' . $action, $id))->assertForbidden();
        }
    }

    public function test_public_and_category_pagination_exclude_unpublished_posts(): void
    {
        $repository = app(PostRepositoryInterface::class);
        $service = app(PostService::class);
        $userId = $this->userId();
        DB::table('profiles')->insert(['user_id' => $userId, 'avatar' => '/avatar.png', 'public' => true]);
        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'test-category', 'displayname' => 'Test category', 'has_child' => false,
        ]);

        config(['pagination.postsPerPage' => 1]);
        foreach (['first', 'second', 'draft'] as $slug) {
            $repository->store(Post::create(null, $slug, $slug, '', $slug, '', '', ''), $userId, [$categoryId]);

            if ($slug !== 'draft') {
                $service->publish((int) DB::table('posts')->where('slug', $slug)->value('id'));
            }
        }

        $this->assertSame(3, $service->getPaginatedPostsOrderedById(1)->total());
        $this->assertSame(2, $service->calculateAndPaginate($service->getPostsForPage(1, 1), 1)->total());

        $parameters = ['category' => 'test-category', 'id' => 2];
        $this->get(route('category.show', ['category' => 'test-category']))->assertOk();
        $this->get(route('category.paginate', $parameters))->assertOk();
        $this->getJson(route('category.paginate', $parameters))->assertOk()
            ->assertJsonPath('pagination.last', 2)
            ->assertJsonPath('pagination.current', 2)
            ->assertJsonPath('posts.0.slug', 'first');
    }

    private function postEntity(?int $id, string $title): Post
    {
        return Post::create($id, 'repository-test', $title, '', 'Post', '', '', '');
    }

    private function userId(): int
    {
        return DB::table('users')->insertGetId(['username' => 'post-author', 'email' => 'post-author@example.test']);
    }
}
