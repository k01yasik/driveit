<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

class MessageQueryBuilder extends Builder
{
    public function forConversation(int $userId1, int $userId2): self
    {
        return $this->where(function($query) use ($userId1, $userId2) {
            $query->where('user_id', $userId1)
                  ->where('friend_id', $userId2);
        })->orWhere(function($query) use ($userId1, $userId2) {
            $query->where('user_id', $userId2)
                  ->where('friend_id', $userId1);
        });
    }
}
