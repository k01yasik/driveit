<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    public function show($categoryInput) {

        $category = Category::where('name', $categoryInput)->firstOrFail();

        $categories = [];

        if ($category->parent_id) {
            $mainCategory = Category::find($category->parent_id);

            array_push($categories, ['name' => $mainCategory->name, 'displayname' => $mainCategory->displayname]);
        }

        array_push($categories, ['name' => $category->name, 'displayname' => $category->displayname]);

        $seo = [
            "title" => 'Статьи в категории '.$category->displayname,
            "description" => 'Все статьи в категории '.$category->displayname,
        ];

        $posts = $category->posts()->with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        $categoryName = $category->name;

        return view('category.show', compact('seo', 'posts', 'categories', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage', 'categoryName'));
    }

    public function paginate($categoryInput, $id) {

        $category = Category::where('name', $categoryInput)->firstOrFail();

        $categories = [];

        if ($category->parent_id) {
            $mainCategory = Category::find($category->parent_id);

            array_push($categories, ['name' => $mainCategory->name, 'displayname' => $mainCategory->displayname]);
        }

        array_push($categories, ['name' => $category->name, 'displayname' => $category->displayname]);

        $seo = [
            "title" => 'Статьи в категории '.$category->displayname.'. Страница - '.$id.'.',
            "description" => 'Статьи в категории '.$category->displayname.'. Страница - '.$id.'.',
        ];

        $posts = $category->posts()->with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10, ['*'], 'page', $id);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        $categoryName = $category->name;

        return view('category.show', compact('seo', 'posts', 'categories', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage', 'categoryName'));
    }
}