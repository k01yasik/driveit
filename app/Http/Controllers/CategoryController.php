<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\PaginatorService;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly PostService $postService,
        private readonly PaginatorService $paginatorService
    ) {
    }

    public function show(Request $request, string $category, int $id = 1): View|JsonResponse
    {
        $category = $this->categoryService->getCategoryByName($category);
        $posts = $this->postService->getPaginatedPostsByCategoryId($category->id, $id);
        $pages = $this->paginatorService->calculatePages($posts);

        if ($request->routeIs('category.paginate') && $request->expectsJson()) {
            return response()->json(['posts' => $posts->items(), 'pagination' => $pages]);
        }

        $title = 'Статьи в категории ' . $category->displayName;
        $description = $id > 1 ? $title : 'Все ' . $title;
        $suffix = $id > 1 ? '. Страница - ' . $id . '.' : '';

        return view('category.show', [
            'categoryName' => $category->name,
            'lastNumberPage' => $pages['last'],
            'nextNumberPage' => $pages['next'],
            'previousNumberPage' => $pages['previous'],
            'posts' => $posts,
            'categories' => $this->categoryService->getCategoryNameWithParentName($category),
            'seo' => ['title' => $title . $suffix, 'description' => $description . $suffix],
        ]);
    }
}
