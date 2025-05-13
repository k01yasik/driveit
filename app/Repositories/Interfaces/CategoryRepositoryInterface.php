<?php

namespace App\Repositories\Interfaces;

use App\DTO\CategoryDTO;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function getPostCategory(int $id): CategoryDTO;

    public function getAllParentCategories(): Collection;

    public function getCategoryByName(string $name): CategoryDTO;
}
