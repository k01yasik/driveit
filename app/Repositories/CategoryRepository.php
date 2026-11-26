<?php

namespace App\Repositories;

use App\Category;
use App\DTO\CategoryDTO;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    private const COLUMNS = ['id', 'name', 'displayname', 'parent_id'];

    public function getPostCategory(int $id): CategoryDTO
    {
        return $this->toDto(Category::findOrFail($id, self::COLUMNS));
    }

    public function findPostCategory(int $id): ?CategoryDTO
    {
        $category = Category::find($id, self::COLUMNS);

        return $category ? $this->toDto($category) : null;
    }

    public function getAllParentCategories(): Collection
    {
        return Category::hasChild()->get(self::COLUMNS)->map($this->toDto(...));
    }

    public function getCategoriesForPostForm(): Collection
    {
        return Category::orderByRaw('COALESCE(parent_id, id)')
            ->orderBy('id')
            ->get(self::COLUMNS)
            ->map($this->toDto(...));
    }

    public function getCategoryByName(string $name): CategoryDTO
    {
        return $this->toDto(Category::where('name', $name)->firstOrFail(self::COLUMNS));
    }

    private function toDto(Category $category): CategoryDTO
    {
        return new CategoryDTO(
            id: $category->id,
            name: $category->name,
            displayName: $category->displayname,
            parentId: $category->parent_id
        );
    }
}
