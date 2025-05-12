<?php

declare(strict_types=1);

namespace App\Dto;

class CommentUpdateDTO extends CommentDTO
{
    public function __construct(
        public readonly int $id,
        int $userId,
        int $postId,
        string $message,
        int $level,
        ?int $parentId = null,
        bool $isVerified = false
    ) {
        parent::__construct($userId, $postId, $message, $level, $parentId, $isVerified);
    }
}
