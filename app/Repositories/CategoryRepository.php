<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use App\DTO\CategoryDTO;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getPostCategory(int $id): CategoryDTO
    {
        $category = Category::findOrFail($id);
        
        return new CategoryDTO(
            id: $category->id,
            name: $category->name,
            displayName: $category->displayname,
            parentId: $category->parent_id
        );
    }

    public function getAllParentCategories(): Collection
    {
        return Category::hasChild()->get()->map(
            fn (Category $category) => new CategoryDTO(
                id: $category->id,
                name: $category->name,
                displayName: $category->displayname,
                parentId: $category->parent_id
            )
        );
    }

    public function getCategoryByName(string $name): CategoryDTO
    {
        $category = Category::where('name', $name)->firstOrFail();
        
        return new CategoryDTO(
            id: $category->id,
            name: $category->name,
            displayName: $category->displayname,
            parentId: $category->parent_id
        );
    }
}
