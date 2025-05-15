<?php

namespace App\Repositories\Interfaces;

use App\Entities\Message;

interface MessageRepositoryInterface
{
    public function add(Message $message): void;
    public function getMessages(int $currentUserId, int $friendId): array;
}
