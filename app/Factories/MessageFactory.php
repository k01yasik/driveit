<?php

namespace App\Factories;

use App\Entities\Message;

class MessageFactory
{
    public function create(int $userId, int $friendId, string $text): Message
    {
        return new Message($userId, $friendId, $text);
    }
}
