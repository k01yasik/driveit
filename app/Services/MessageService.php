<?php

namespace App\Services;

use App\Entities\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageService
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository
    ) {}

    public function createMessage(int $userId, int $friendId, string $messageText): Message
    {
        return Message::create($userId, $friendId, $messageText);
    }

    public function saveMessage(Message $message): void
    {
        $this->messageRepository->add($message);
    }

    public function getConversation(int $currentId, int $friendId): array
    {
        return $this->messageRepository->getMessages($currentId, $friendId);
    }
}
