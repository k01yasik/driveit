<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function getPostCategory(int $id): array;

    public function getAllParentCategories(): array;

    public function getCategoryByName(string $name): array;
}