<?php

namespace App\Repositories\Interfaces;

use App\Entities\Message;

interface MessageRepositoryInterface
{
    public function add(Message $message): void;

    public function getMessages(int $current_id, int $friendId): array;
}