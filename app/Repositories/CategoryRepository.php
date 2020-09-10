<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getPostCategory(int $id): array
    {
        return Category::find($id)->toArray();
    }

    public function getAllParentCategories(): array
    {
        return Category::hasChild()->get()->toArray();
    }

    public function getCategoryByName(string $name): array
    {
        return Category::where('name', $name)->first()->toArray();
    }
}