<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function show($categoryInput) {

        $category = Category::where('name', $categoryInput)->firstOrFail();

        $seo = [
            "title" => 'Статьи в категории '.$category->displayname,
            "description" => 'Все статьи в категории '.$category->displayname,
        ];

        $posts = $category->posts()->with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('date_published')->get();

        return view('category.show', compact('seo', 'posts', 'categoryInput'));
    }
}