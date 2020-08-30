<?php

namespace App\Services;


use App\Entities\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageService
{
    private MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function add(Message $message): void
    {
        $this->messageRepository->add($message);
    }

    public function getMessages(int $currentId, int $friendId): array
    {
        $this->messageRepository->getMessages($currentId, $friendId);
    }

    public function create(int $userId, int $friendId, string $message): Message
    {
        return Message::create($userId, $friendId, $message);
    }
}