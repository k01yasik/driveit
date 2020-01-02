<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MessageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Message;

class MessageRepository implements MessageRepositoryInterface
{

    public function store(int $userId, int $friendId, string $message): Model
    {
        $messageEntry = new Message;
        $messageEntry->user_id = $userId;
        $messageEntry->text = $message;
        $messageEntry->friend_id = $friendId;
        $messageEntry->save();

        return $messageEntry;
    }

    public function getMessages(int $current_id, int $friend_id): Collection
    {
        return Message::with(['user', 'user.profile', 'friend', 'friend.profile'])
            ->where([['user_id', $current_id], ['friend_id', $friend_id]])
            ->orWhere([['user_id', $friend_id], ['friend_id', $current_id]])
            ->orderBy('created_at')
            ->get();
    }
}