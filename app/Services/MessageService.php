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

    public function addMessage(Message $message): int
    {
        return $this->messageRepository->add($message);
    }

    public function getThreads(int $userId): array
    {
        return $this->messageRepository->getThreads($userId);
    }

    public function getUnreadCount(int $userId): int
    {
        return $this->messageRepository->getUnreadCount($userId);
    }

    public function markRead(int $userId, int $senderId, int $messageId): void
    {
        $this->messageRepository->markRead($userId, $senderId, $messageId);
    }

    public function getConversation(int $currentUserId, int $friendId): array
    {
        $messages = $this->messageRepository->getMessages($currentUserId, $friendId);
        $latestIncomingId = collect($messages)->where('friend_id', $currentUserId)
            ->where('new', true)->max('id');

        if ($latestIncomingId !== null) {
            $this->messageRepository->markRead($currentUserId, $friendId, $latestIncomingId, through: true);
        }

        return $messages;
    }

    public function createMessage(int $userId, int $friendId, string $text): Message
    {
        return $this->messageFactory->create($userId, $friendId, $text);
    }
}
