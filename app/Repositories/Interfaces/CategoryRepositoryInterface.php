<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function getPostCategory($id): array;

    public function getAllParentCategories(): array;

    public function getCategoryByName(string $name): array;
}