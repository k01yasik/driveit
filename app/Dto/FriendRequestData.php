<?php

namespace App\DTO;

class FriendRequestData
{
    public function __construct(
        public int $userId,
        public int $friendId,
        public bool $isOwner
    ) {}
}
