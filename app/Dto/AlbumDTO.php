<?php

namespace App\DTO;

class AlbumDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $userId
    ) {}
}
