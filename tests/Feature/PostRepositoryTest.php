<?php

namespace Tests\Feature;

use App\Entities\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\PostService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_publication_toggle_refreshes_a_warmed_post_listing(): void
    {
        $repository = app(PostRepositoryInterface::class);
        $repository->store($this->postEntity(null, 'Original'), $this->userId(), []);
        $post = $this->postEntity((int) DB::table('posts')->value('id'), 'Original');
        $service = app(PostService::class);

        $this->assertFalse($repository->getPostStatus($post));
        $this->assertSame([], $repository->getTopPosts(3));

        $service->changePublishStatus($post);
        $this->assertTrue($repository->getPostStatus($post));
        $this->assertCount(1, $repository->getTopPosts(3));

        $service->changePublishStatus($post);
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

    private function postEntity(?int $id, string $title): Post
    {
        return Post::create($id, 'repository-test', $title, '', 'Post', '', '', '');
    }

    private function userId(): int
    {
        return DB::table('users')->insertGetId(['username' => 'post-author', 'email' => 'post-author@example.test']);
    }
}
