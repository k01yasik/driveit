<?php

namespace App\Policies;

use App\Comment;
use App\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment): bool
    {
        return (int) $comment->user_id === (int) $user->id;
    }

    public function moderate(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
