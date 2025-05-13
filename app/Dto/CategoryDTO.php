<?php

namespace App\DTO;

class CategoryDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $displayName,
        public readonly ?int $parentId = null
    ) {
    }
}
