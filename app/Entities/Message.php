<?php

namespace App\Entities;

use Carbon\CarbonImmutable;

class Message
{
    private int $userId;
    private int $friendId;
    private CarbonImmutable $createdAt;
    private string $messageText;

    private function __construct(int $userId, int $friendId, string $messageText, ?CarbonImmutable $createdAt = null)
    {
        $this->userId = $userId;
        $this->friendId = $friendId;
        $this->messageText = $messageText;
        $this->createdAt = $createdAt ?? CarbonImmutable::now();
    }

    public static function create(int $userId, int $friendId, string $messageText): self
    {
        return new self($userId, $friendId, $messageText);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getMessageText(): string
    {
        return $this->messageText;
    }

    public function getFriendId(): int
    {
        return $this->friendId;
    }

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->createdAt;
    }
    
    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'friend_id' => $this->friendId,
            'message_text' => $this->messageText,
            'created_at' => $this->createdAt,
        ];
    }
}
