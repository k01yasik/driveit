<?php

declare(strict_types=1);

namespace App\DTO;

class CommentDTO
{
    public function __construct(
        public readonly int $postId,
        public readonly string $message,
        public readonly int $level,
        public readonly int $parentId
    ) {}
}
