<?php

declare(strict_types=1);

namespace App\DTO;

class CommentStoreResultDTO
{
    public function __construct(
        public readonly int $level,
        public readonly string $username,
        public readonly string $avatar,
        public readonly string $url,
        public readonly string $createdAt,
        public readonly string $message
    ) {}
}
