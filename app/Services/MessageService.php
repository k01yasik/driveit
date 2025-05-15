<?php

namespace App\Services;

use App\Entities\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Factories\MessageFactory;

class MessageService
{
    private MessageRepositoryInterface $messageRepository;
    private MessageFactory $messageFactory;

    public function __construct(
        MessageRepositoryInterface $messageRepository,
        MessageFactory $messageFactory
    ) {
        $this->messageRepository = $messageRepository;
        $this->messageFactory = $messageFactory;
    }

    public function addMessage(Message $message): void
    {
        $this->messageRepository->add($message);
    }

    public function getConversation(int $currentUserId, int $friendId): array
    {
        return $this->messageRepository->getMessages($currentUserId, $friendId);
    }

    public function createMessage(int $userId, int $friendId, string $text): Message
    {
        return $this->messageFactory->create($userId, $friendId, $text);
    }
}
