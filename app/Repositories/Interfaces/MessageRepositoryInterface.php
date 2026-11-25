<?php

namespace App\Repositories\Interfaces;

use App\Entities\Message;

interface MessageRepositoryInterface
{
    public function add(Message $message): int;
    public function getThreads(int $userId): array;
    public function getUnreadCount(int $userId): int;
    public function markRead(int $userId, int $senderId, int $messageId, bool $through = false): void;
    public function getMessages(int $currentUserId, int $friendId): array;
}
