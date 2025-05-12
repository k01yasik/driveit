<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class ModelTest extends TestCase
{
    public function testCommentRelationships()
    {
        $comment = Comment::factory()
            ->for(User::factory())
            ->for(Post::factory())
            ->create();

        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertInstanceOf(Post::class, $comment->post);
    }

    public function testCreatedAtAccessor()
    {
        $comment = Comment::factory()->create();
        $this->assertIsString($comment->created_at);
        $this->assertStringContainsString('назад', $comment->created_at);
    }
}
