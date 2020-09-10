<?php

namespace App\Services;

use App\Category;
use App\Post;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getParentCategoryId(array $category): ?int
    {
        if ($category['parent_id']) return $category['parent_id'];

        return null;
    }

    public function getPostAllCategoriesId(array $category): array
    {
        $postCategoriesId = [];

        $parentId = $this->getParentCategoryId($category);

        if (!is_null($parentId)) array_push($postCategoriesId, $parentId);

        array_push($postCategoriesId, $category['id']);

        return $postCategoriesId;
    }

    public function getCategoryByName(string $name): array
    {
        return $this->categoryRepository->getCategoryByName($name);
    }

    public function getPostCategoriesIdByPost(array $post): array
    {
        $categoryArray = [];

        foreach ($post['categories'] as $category) {
            array_push($categoryArray, $category['id']);
        }

        return $categoryArray;
    }

    public function getCategoryNameWithParentName(array $category): array
    {
        $categories = [];

        $parentId = $this->getParentCategoryId($category);

        if (!is_null($parentId)) {
            $mainCategory = $this->categoryRepository->getPostCategory($parentId);
            $categories[] = $this->makeCategoryResponse($mainCategory);
        }

        $categories[] = $this->makeCategoryResponse($category);

        return $categories;
    }

    public function getAllParentCategories(): array
    {
        return $this->categoryRepository->getAllParentCategories();
    }

    public function getPostCategory(int $categoryId): array
    {
        return $this->categoryRepository->getPostCategory($categoryId);
    }

    protected function makeCategoryResponse(array $category)
    {
        return ['name' => $category['name'], 'displayname' => $category['displayname']];
    }
}