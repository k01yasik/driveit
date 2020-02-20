<?php

namespace App\Services;

use App\Category;
use App\Post;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model as Model;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getParentCategoryId(Category $category): ?int
    {
        if ($category->parent_id) return $category->parent_id;

        return null;
    }

    public function getPostAllCategoriesId(Category $category): array
    {
        $postCategoriesId = [];

        $parentId = $this->getParentCategoryId($category);

        if (!is_null($parentId)) array_push($postCategoriesId, $parentId);

        array_push($postCategoriesId, $category->id);

        return $postCategoriesId;
    }


    public function getPostCategoriesIdByPost(Post $post): array
    {
        $categoryArray = [];

        foreach ($post->categories as $category) {
            array_push($categoryArray, $category->id);
        }

        return $categoryArray;
    }

    public function getCategoryNameWithParentName(Model $category): array
    {
        $categories = [];

        $parentId = $this->getParentCategoryId($category);

        if (!is_null($parentId)) {
            $mainCategory = $this->categoryRepository->getPostCategory($parentId);
            array_push($categories, ['name' => $mainCategory->name, 'displayname' => $mainCategory->displayname]);
        }

        array_push($categories, ['name' => $category->name, 'displayname' => $category->displayname]);

        return $categories;
    }
}