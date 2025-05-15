<?php

namespace App\Entities;

use Carbon\Carbon;

class Message
{
    private int $userId;
    private int $friendId;
    private Carbon $createdAt;
    private string $text;

    public function __construct(int $userId, int $friendId, string $text)
    {
        $this->userId = $userId;
        $this->friendId = $friendId;
        $this->text = $text;
        $this->createdAt = Carbon::now();
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getFriendId(): int
    {
        return $this->friendId;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'friend_id' => $this->friendId,
            'text' => $this->text,
            'created_at' => $this->createdAt,
        ];
    }
}
