<?php

namespace App\Services;

use App\Category;

class CategoryService
{
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
}