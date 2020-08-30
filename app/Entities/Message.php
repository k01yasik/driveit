<?php


namespace App\Entities;

class Message
{
    private int $userId;
    private int $friendId;
    private int $createdAt;
    private string $message;

    private function __construct(int $userId, int $friendId, string $message)
    {
        $this->userId = $userId;
        $this->friendId = $friendId;
        $this->message = $message;
        $this->createdAt = now()->timestamp;
    }

    public static function create(int $userId, int $friendId, string $message)
    {
        return new self($userId, $friendId, $message);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getMessageText(): string
    {
        return $this->message;
    }

    public function getFriendId(): int
    {
        return $this->friendId;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }
}