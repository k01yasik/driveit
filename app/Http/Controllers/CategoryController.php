<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\PaginatorService;
use App\Services\PostService;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    protected PostService $postService;
    protected PaginatorService $paginatorService;

    public function __construct(CategoryService $categoryService,
                                PostService $postService,
                                PaginatorService $paginatorService)
    {
        $this->categoryService = $categoryService;
        $this->postService = $postService;
        $this->paginatorService = $paginatorService;
    }

    public function show($name) {
        return view('category.show');
    }

    public function paginate($name, $id) {
        return view('category.show');
    }
}