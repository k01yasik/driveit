<?php


namespace App\Http\View\Composers;

use App\Services\CategoryService;
use App\Services\PaginatorService;
use App\Services\PostService;
use Illuminate\View\View;

class CategoryComposer
{
    private $postService;
    private $paginatorService;
    private $categoryService;

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
            $posts = $this->postService->getPaginatedPostsByCategory($category, false, $id);

            $seo = [
                "title" => 'Статьи в категории '.$category['displayname'].'. Страница - '.$id.'.',
                "description" => 'Статьи в категории '.$category['displayname'].'. Страница - '.$id.'.',
            ];
        } else {
            $posts = $this->postService->getPaginatedPostsByCategory($category, true);

            $seo = [
                "title" => 'Статьи в категории '.$category['displayname'],
                "description" => 'Все статьи в категории '.$category['displayname'],
            ];
        }


        foreach ($posts as $post) {
            $this->postService->countPostComments($post);
            $this->postService->countPostRating($post);
        }

        $pages = $this->paginatorService->calculatePages($posts);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

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