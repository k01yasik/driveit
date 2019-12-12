<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MessageRepositoryInterface;
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
}