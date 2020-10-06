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

    public function __construct(PostService $postService, PaginatorService $paginatorService, CategoryService $categoryService)
    {
        $this->postService = $postService;
        $this->paginatorService = $paginatorService;
        $this->categoryService = $categoryService;
    }

    public function compose(View $view)
    {
        $category = $this->categoryService->getCategoryByName(request()->route()->parameter('category'));

        $categories = $this->categoryService->getCategoryNameWithParentName($category);

        $id = request()->route()->parameter('id');

        if ($id) {
            $posts = $this->postService->getPaginatedPostsByCategoryId($category['id'], $id);

            $seo = [
                "title" => 'Статьи в категории '.$category['displayname'].'. Страница - '.$id.'.',
                "description" => 'Статьи в категории '.$category['displayname'].'. Страница - '.$id.'.',
            ];
        } else {
            $posts = $this->postService->getPaginatedPostsByCategoryId($category['id'], 1);

            $seo = [
                "title" => 'Статьи в категории '.$category['displayname'],
                "description" => 'Все статьи в категории '.$category['displayname'],
            ];
        }

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        $categoryName = $category['name'];

        $view->with('categoryName', $categoryName)
            ->with('lastNumberPage', $lastNumberPage)
            ->with('nextNumberPage', $nextNumberPage)
            ->with('previousNumberPage', $previousNumberPage)
            ->with('posts', $posts)
            ->with('categories', $categories)
            ->with('seo', $seo);
    }
}