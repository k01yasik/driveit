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
        $postCategoriesId = [$category->id];

        if ($category->parentId !== null) {
            $postCategoriesId[] = $category->parentId;
        }

        return $postCategoriesId;
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
        $categories = [];

        if ($category->parentId !== null) {
            $mainCategory = $this->categoryRepository->getPostCategory($category->parentId);
            $categories[] = $this->makeCategoryResponse($mainCategory);
        }

        $categories[] = $this->makeCategoryResponse($category);

        return $categories;
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
