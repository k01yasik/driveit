<?php

namespace Tests\Unit\Models;

use App\Comment;
use App\Post;
use App\User;
use Tests\TestCase;

class ModelTest extends TestCase
{
    public function testCommentRelationships()
    {
        $comment = new Comment();

        $this->assertInstanceOf(User::class, $comment->user()->getRelated());
        $this->assertInstanceOf(Post::class, $comment->post()->getRelated());
    }

    public function testCreatedAtAccessor()
    {
        $comment = new Comment();
        $comment->created_at = now()->subMinutes(2);
        $this->assertIsString($comment->created_at);
        $this->assertStringContainsString('назад', $comment->created_at);
    }
}
