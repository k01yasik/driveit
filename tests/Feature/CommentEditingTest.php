<?php

namespace Tests\Feature;

use App\Comment;
use App\Repositories\CachedCommentRepository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CommentEditingTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_edit_resets_moderation_and_invalidates_the_thread_cache(): void
    {
        [$author, $comment] = $this->publishedComment();
        $repository = app(CachedCommentRepository::class);
        $this->assertSame('Original comment', $repository->getByPostId($comment->post_id)[0]['message']);
        $this->assertSame(1, $repository->getVerifiedCount());
        $parameters = [$author->username, $comment];

        $this->actingAs($author)->get(route('user.comment.edit', $parameters))->assertOk();
        $this->patch(route('user.comment.update', $parameters), ['message' => 'Original comment'])->assertRedirect();
        $this->assertTrue($comment->refresh()->is_verified);
        $this->patch(route('user.comment.update', $parameters), ['message' => '<b>Updated comment</b>'])->assertRedirect();

        $this->assertFalse($comment->refresh()->is_verified);
        $this->assertStringContainsString('Updated comment', $comment->message);
        $this->assertSame($comment->message, $repository->getByPostId($comment->post_id)[0]['message']);
        $this->assertSame(0, $repository->getVerifiedCount());
    }

    public function test_another_user_cannot_edit_the_comment_but_an_admin_can(): void
    {
        [$author, $comment] = $this->publishedComment();
        $other = $this->verifiedUser('second-user');

        $this->actingAs($other)
            ->get(route('user.comment.edit', [$other->username, $comment]))->assertForbidden();
        $this->patch(route('user.comment.update', [$other->username, $comment]), ['message' => 'Unauthorized edit'])->assertForbidden();
        $this->patch(route('admin.comment.update', $comment), ['message' => 'Unauthorized edit'])->assertForbidden();
        $this->assertSame('Original comment', $comment->refresh()->message);

        $other->assignRole(Role::findOrCreate('admin', 'web'));
        $this->get(route('admin.comment.edit', $comment))->assertOk();
        $this->patchJson(route('admin.comment.update', $comment), ['message' => '<p>&nbsp;</p>'])->assertUnprocessable();
        $this->patch(route('admin.comment.update', $comment), ['message' => 'Admin edit'])->assertRedirect(route('admin.comments'));
        $this->assertFalse($comment->refresh()->is_verified);
        $this->assertSame('Admin edit', $comment->message);

        $this->putJson(route('admin.comments.publish'), ['id' => $comment->id])->assertOk();
        $this->assertTrue($comment->refresh()->is_verified);
        $this->assertSame('Admin edit', $comment->message);
    }

    private function publishedComment(): array
    {
        $author = $this->verifiedUser('comment-author');
        $postId = DB::table('posts')->insertGetId([
            'slug' => 'comment-edit-post', 'title' => 'Post', 'name' => 'Post', 'description' => '',
            'caption' => '', 'body' => '', 'image_path' => '', 'is_published' => true, 'views' => 0,
            'user_id' => $author->id,
        ]);
        $id = DB::table('comments')->insertGetId([
            'post_id' => $postId, 'user_id' => $author->id, 'message' => 'Original comment',
            'is_verified' => true, 'level' => 0, 'created_at' => now(), 'updated_at' => now(),
        ]);

        return [$author, Comment::findOrFail($id)];
    }

    private function verifiedUser(string $username): User
    {
        $id = DB::table('users')->insertGetId([
            'username' => $username, 'email' => $username.'@example.test', 'email_verified_at' => now(),
        ]);

        return User::findOrFail($id);
    }
}
