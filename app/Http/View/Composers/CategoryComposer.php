<?php

namespace App\Http\View\Composers;

use App\Services\CategoryService;
use App\Services\PaginatorService;
use App\Services\PostService;
use Illuminate\View\View;

class CategoryComposer
{
    private PostService $postService;
    private PaginatorService $paginatorService;
    private CategoryService $categoryService;

    public function __construct(
        PostService $postService,
        PaginatorService $paginatorService,
        CategoryService $categoryService
    ) {
        $this->postService = $postService;
        $this->paginatorService = $paginatorService;
        $this->categoryService = $categoryService;
    }

    public function compose(View $view): void
    {
        $categoryName = request()->route()->parameter('category');
        $pageId = request()->route()->parameter('id') ?? 1;

        $category = $this->categoryService->getCategoryByName($categoryName);
        $categories = $this->categoryService->getCategoryNameWithParentName($category);
        $posts = $this->postService->getPaginatedPostsByCategoryId($category['id'], $pageId);

        $view->with($this->prepareViewData($category, $categories, $posts, $pageId));
    }

    /**
     * Prepare all view data in a structured way
     *
     * @param array $category
     * @param mixed $categories
     * @param LengthAwarePaginator $posts
     * @param int $pageId
     * @return array
     */
    private function prepareViewData(array $category, $categories, $posts, int $pageId): array
    {
        $paginationData = $this->paginatorService->calculatePages($posts);
        
        return [
            'categoryName' => $category['name'],
            'lastNumberPage' => $paginationData['last'],
            'nextNumberPage' => $paginationData['next'],
            'previousNumberPage' => $paginationData['previous'],
            'posts' => $posts,
            'categories' => $categories,
            'seo' => $this->generateSeoData($category, $pageId),
        ];
    }

    /**
     * Generate SEO metadata based on category and page
     *
     * @param array $category
     * @param int $pageId
     * @return array
     */
    private function generateSeoData(array $category, int $pageId): array
    {
        $baseTitle = 'Статьи в категории ' . $category['displayname'];
        $baseDescription = 'Статьи в категории ' . $category['displayname'];

        if ($pageId > 1) {
            return [
                'title' => $baseTitle . '. Страница - ' . $pageId . '.',
                'description' => $baseDescription . '. Страница - ' . $pageId . '.',
            ];
        }

        return [
            'title' => $baseTitle,
            'description' => 'Все ' . $baseDescription,
        ];
    }
}
