<?php

declare(strict_types=1);

namespace App\DTO;

class PostDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $content,
        public readonly int $authorId,
        public readonly ?array $stats = null
    ) {}
}
