<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\DTO\CategoryDTO;
use Illuminate\Support\Collection;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function getParentCategoryId(CategoryDTO $category): ?int
    {
        return $category->parentId;
    }

    public function getPostAllCategoriesId(CategoryDTO $category): array
    {
        $parent = $this->findParent($category);

        return $parent ? [$category->id, $parent->id] : [$category->id];
    }

    public function getCategoriesForPostForm(): Collection
    {
        return $this->categoryRepository->getCategoriesForPostForm();
    }

    public function getSelectedCategoryId(Collection $postCategories): ?int
    {
        $category = $postCategories->first(fn ($item) => data_get($item, 'parent_id') !== null)
            ?? $postCategories->first();

        return data_get($category, 'id');
    }

    public function getCategoryByName(string $name): CategoryDTO
    {
        return $this->categoryRepository->getCategoryByName($name);
    }

    public function getPostCategoriesIdByPost(Collection $postCategories): array
    {
        return $postCategories->pluck('id')->toArray();
    }

    public function getCategoryNameWithParentName(CategoryDTO $category): array
    {
        $parent = $this->findParent($category);

        return $parent
            ? [$this->makeCategoryResponse($parent), $this->makeCategoryResponse($category)]
            : [$this->makeCategoryResponse($category)];
    }

    private function findParent(CategoryDTO $category): ?CategoryDTO
    {
        if ($category->parentId === null || $category->parentId === $category->id) {
            return null;
        }

        return $this->categoryRepository->findPostCategory($category->parentId);
    }

    public function getAllParentCategories(): Collection
    {
        return $this->categoryRepository->getAllParentCategories();
    }

    public function getPostCategory(int $categoryId): CategoryDTO
    {
        return $this->categoryRepository->getPostCategory($categoryId);
    }

    protected function makeCategoryResponse(CategoryDTO $category): array
    {
        return [
            'name' => $category->name,
            'displayname' => $category->displayName
        ];
    }
}
