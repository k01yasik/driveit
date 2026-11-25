<?php

namespace Tests\Feature;

use App\Comment;
use App\Repositories\CachedCommentRepository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CommentLifecycleTest extends TestCase
{
    use RefreshDatabase;

    private User $author;
    private int $postId;

    protected function setUp(): void
    {
        parent::setUp();
        $userId = DB::table('users')->insertGetId([
            'username' => 'thread-author', 'email' => 'thread-author@example.test', 'email_verified_at' => now(),
        ]);
        DB::table('profiles')->insert(['user_id' => $userId, 'avatar' => '/avatar.png', 'public' => true]);
        $this->author = User::findOrFail($userId);
        $this->postId = $this->insertPost('comment-thread');
    }

    public function test_guest_cannot_create_or_moderate_comments(): void
    {
        $this->postJson(route('comment.store'), $this->payload())->assertUnauthorized();
        $this->postJson("/posts/{$this->postId}/comments", $this->payload())->assertUnauthorized();
        $this->putJson(route('admin.comments.publish'), ['id' => 1])->assertUnauthorized();
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_both_creation_routes_save_pending_comments_and_refresh_cached_thread_and_count(): void
    {
        $repository = app(CachedCommentRepository::class);
        $this->assertSame([], $repository->getByPostId($this->postId));
        $this->assertSame(0, $repository->getUnverifiedCount());
        $this->assertSame([], $repository->getUnverified());

        $this->actingAs($this->author)->postJson(route('comment.store'), $this->payload(['parent' => 0]))
            ->assertOk()
            ->assertJsonPath('username', $this->author->username)
            ->assertJsonPath('avatar', '/avatar.png')
            ->assertJsonPath('url', route('user.profile', $this->author->username))
            ->assertJsonPath('level', 0)
            ->assertJsonStructure(['created_at', 'message']);

        $this->postJson("/posts/{$this->postId}/comments", $this->payload([
            'post' => 999_999, 'message' => 'Canonical route comment',
        ]))->assertOk();

        $this->assertDatabaseHas('comments', [
            'post_id' => $this->postId, 'user_id' => $this->author->id, 'message' => 'Root comment',
            'parent_id' => null, 'level' => 0, 'is_verified' => false,
        ]);
        $this->assertDatabaseHas('comments', ['post_id' => $this->postId, 'message' => 'Canonical route comment']);
        $this->assertCount(2, $repository->getByPostId($this->postId));
        $this->assertSame(2, $repository->getUnverifiedCount());
        $this->assertCount(2, $repository->getUnverified());
    }

    public function test_reply_is_linked_to_parent_with_both_parameter_names(): void
    {
        $root = $this->seedComment('Seeded root', true);
        $this->actingAs($this->author)
            ->postJson(route('comment.store'), $this->payload(['parent' => $root->id, 'level' => 1, 'message' => 'Legacy reply']))
            ->assertOk()->assertJsonPath('level', 1);
        $this->postJson("/posts/{$this->postId}/comments", $this->payload([
            'parent_id' => $root->id, 'level' => 1, 'message' => 'Canonical reply',
        ]))->assertOk()->assertJsonPath('level', 1);

        foreach (['Legacy reply', 'Canonical reply'] as $text) {
            $this->assertDatabaseHas('comments', [
                'parent_id' => $root->id, 'post_id' => $this->postId, 'level' => 1,
                'message' => $text, 'is_verified' => false,
            ]);
        }
    }

    #[DataProvider('invalidPayloads')]
    public function test_invalid_creation_payload_does_not_create_a_comment(array $overrides, string $field): void
    {
        $this->actingAs($this->author)->postJson(route('comment.store'), $this->payload($overrides))
            ->assertUnprocessable()->assertJsonValidationErrors($field);
        $this->assertDatabaseCount('comments', 0);
    }

    public static function invalidPayloads(): iterable
    {
        yield 'missing post' => [['post' => null], 'post'];
        yield 'unknown post' => [['post' => 999_999], 'post'];
        yield 'empty body' => [['message' => ''], 'message'];
        yield 'non-text body' => [['message' => ['bad']], 'message'];
        yield 'too long' => [['message' => str_repeat('a', 5001)], 'message'];
        yield 'negative level' => [['level' => -1], 'level'];
        yield 'level above maximum' => [['level' => 6], 'level'];
        yield 'missing level' => [['level' => null], 'level'];
        yield 'negative parent' => [['parent_id' => -1], 'parent_id'];
        yield 'unknown parent' => [['parent_id' => 999_999], 'parent_id'];
    }

    public function test_reply_to_a_comment_on_another_post_is_rejected(): void
    {
        $parent = $this->seedComment('Other post parent', true, postId: $this->insertPost('another-thread'));
        $this->actingAs($this->author)
            ->postJson(route('comment.store'), $this->payload(['parent_id' => $parent->id, 'level' => 1]))
            ->assertUnprocessable()->assertJsonValidationErrors('parent_id');
        $this->assertDatabaseCount('comments', 1);
    }

    public function test_public_page_displays_a_reply_only_while_it_is_published(): void
    {
        $root = $this->seedComment('Public root text', true);
        $reply = $this->seedComment('Moderated reply text', false, parent: $root);
        $url = route('posts.show', 'comment-thread');

        $this->get($url)->assertOk()->assertSee('Public root text')->assertDontSee('Moderated reply text');
        $this->actingAs($this->admin())->putJson(route('admin.comments.publish'), ['id' => $reply->id])->assertOk();
        $this->app['auth']->guard()->logout();
        $this->get($url)->assertOk()->assertSeeInOrder(['Public root text', 'Moderated reply text'])
            ->assertSee('id="comment-'.$reply->id.'"', false)
            ->assertDontSee(route('user.comment.edit', [$this->author->username, $reply]));

        $this->actingAs($this->author)->get($url)
            ->assertOk()->assertSee(route('user.comment.edit', [$this->author->username, $reply]));
        $this->actingAs($this->admin())->putJson(route('admin.comments.publish'), ['id' => $reply->id])->assertOk();
        $this->app['auth']->guard()->logout();
        $this->get($url)->assertOk()->assertDontSee('Moderated reply text')->assertSee('Public root text');
    }

    public function test_admin_filters_and_pagination_show_the_correct_comments(): void
    {
        config(['pagination.comments_per_page' => 1]);
        $this->seedComment('Pending list item', false);
        $this->seedComment('Published list item', true, createdMinutesAgo: 2);
        foreach (['admin.comments', 'admin.comments.unpublished'] as $route) {
            DB::table('seo')->insert(['route_name' => $route, 'title' => 'Comments', 'description' => 'Test']);
        }

        $this->actingAs($this->admin())->get(route('admin.comments'))
            ->assertOk()->assertSee('Pending list item')->assertDontSee('Published list item')
            ->assertSee(route('admin.comments.paginate', 2));
        $this->get(route('admin.comments.paginate', 2))
            ->assertOk()->assertSee('Published list item')->assertDontSee('Pending list item');
        $this->get(route('admin.comments.unpublished'))
            ->assertOk()->assertSee('Pending list item')->assertDontSee('Published list item')
            ->assertViewHas('unpublish_comments_count', 1);
    }

    public function test_moderation_requires_admin_and_valid_comment_id(): void
    {
        $comment = $this->seedComment('Pending text', false);
        $url = route('admin.comments.publish');
        $this->actingAs($this->author)->putJson($url, ['id' => $comment->id])->assertForbidden();
        $this->actingAs($this->admin())->putJson($url, ['id' => 0])->assertUnprocessable()->assertJsonValidationErrors('id');
        $this->putJson($url, ['id' => 999_999])->assertNotFound();
        $this->assertFalse($comment->refresh()->is_verified);
    }

    public function test_edit_routes_require_an_existing_comment_and_validate_text(): void
    {
        $comment = $this->seedComment('Untouched text', true);
        $editUrl = route('user.comment.edit', [$this->author->username, $comment]);
        $updateUrl = route('user.comment.update', [$this->author->username, $comment]);
        $this->get($editUrl)->assertRedirect(route('login'));
        $this->patchJson($updateUrl, ['message' => 'Guest edit'])->assertUnauthorized();
        $this->actingAs($this->author)
            ->get(route('user.comment.edit', [$this->author->username, 999_999]))->assertNotFound();
        $this->patchJson($updateUrl, ['message' => str_repeat('a', 5001)])
            ->assertUnprocessable()->assertJsonValidationErrors('message');
        $this->assertSame('Untouched text', $comment->refresh()->message);
        $this->assertTrue($comment->is_verified);
    }

    private function payload(array $overrides = []): array
    {
        return $overrides + ['post' => $this->postId, 'message' => 'Root comment', 'level' => 0];
    }

    private function insertPost(string $slug): int
    {
        return DB::table('posts')->insertGetId([
            'slug' => $slug, 'title' => 'Thread post', 'name' => 'Thread post', 'description' => '',
            'caption' => '', 'body' => '', 'image_path' => '', 'is_published' => true, 'views' => 0,
            'date_published' => now()->subDay(), 'user_id' => $this->author->id,
        ]);
    }

    private function seedComment(
        string $text, bool $published, ?Comment $parent = null, ?int $postId = null, int $createdMinutesAgo = 0
    ): Comment {
        $id = DB::table('comments')->insertGetId([
            'post_id' => $postId ?? $this->postId, 'user_id' => $this->author->id, 'message' => $text,
            'is_verified' => $published, 'level' => $parent ? $parent->level + 1 : 0, 'parent_id' => $parent?->id,
            'created_at' => now()->subMinutes($createdMinutesAgo), 'updated_at' => now(),
        ]);

        return Comment::findOrFail($id);
    }

    private function admin(): User
    {
        $id = DB::table('users')->insertGetId([
            'username' => 'moderator-'.(User::count() + 1), 'email' => 'moderator-'.(User::count() + 1).'@example.test',
            'email_verified_at' => now(),
        ]);
        $user = User::findOrFail($id);
        $user->assignRole(Role::findOrCreate('admin', 'web'));

        return $user;
    }
}
