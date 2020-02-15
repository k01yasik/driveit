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

    /**
     * @param Category $category
     * @return array
     */
    public function getPostAllCategoriesId($category)
    {
        $postCategoriesId = [];

        if ($category->parent_id) {
            array_push($postCategoriesId, $category->parent_id);
        }

        array_push($postCategoriesId, $category->id);

        return $postCategoriesId;
    }

    /**
     * @param Post $post
     * @return array
     */
    public function getPostCategoriesIdByPost(Post $post)
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

        if ($category->parent_id) {
            $mainCategory = $this->categoryRepository->getPostCategory($category->parent_id);

            array_push($categories, ['name' => $mainCategory->name, 'displayname' => $mainCategory->displayname]);
        }

        array_push($categories, ['name' => $category->name, 'displayname' => $category->displayname]);

        return $categories;
    }
}