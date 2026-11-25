<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\PaginatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly PostService $postService,
        private readonly PaginatorService $paginatorService
    ) {
    }

    /**
     * Display category page with posts
     */
    public function show(): View
    {
        return view('category.show');
    }

    public function paginate(Request $request, string $category, int $id): View|JsonResponse
    {
        if (! $request->expectsJson()) {
            return $this->show();
        }

        $category = $this->categoryService->getCategoryByName($category);
        $paginator = $this->postService->getPaginatedPostsByCategoryId($category->id, $id);

        return response()->json([
            'posts' => $paginator->items(),
            'pagination' => $this->paginatorService->calculatePages($paginator),
        ]);
    }

    /**
     * Get all parent categories (for navigation/menu)
     */
    public function getParentCategories(): JsonResponse
    {
        $categories = $this->categoryService->getAllParentCategories();
        
        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Get category hierarchy (parent + children)
     */
    public function getCategoryWithChildren(string $name): JsonResponse
    {
        $category = $this->categoryService->getCategoryByName($name);
        $children = $this->categoryService->getChildCategories($category->id);
        
        return response()->json([
            'category' => $category,
            'children' => $children
        ]);
    }

    /**
     * Search categories by name (autocomplete)
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);
        
        $results = $this->categoryService->searchCategories(
            $request->input('query'),
            $request->input('limit', 5)
        );
        
        return response()->json($results);
    }

    /**
     * Get popular categories
     */
    public function getPopularCategories(): JsonResponse
    {
        $categories = $this->categoryService->getPopularCategories(
            config('app.popular_categories_limit', 10)
        );
        
        return response()->json([
            'popular_categories' => $categories
        ]);
    }
}
