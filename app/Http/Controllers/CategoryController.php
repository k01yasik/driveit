<?php

namespace App\Http\Controllers;

use App\Repositories\CachedPostRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\CategoryService;
use App\Services\PaginatorService;
use App\Services\PostService;

class CategoryController extends Controller
{
    protected $categoryRepository;
    protected $categoryService;
    protected $postRepository;
    protected $postService;
    protected $paginatorService;

    public function __construct(CategoryRepositoryInterface $categoryRepository,
                                CategoryService $categoryService,
                                CachedPostRepository $postRepository,
                                PostService $postService,
                                PaginatorService $paginatorService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
        $this->postRepository = $postRepository;
        $this->postService = $postService;
        $this->paginatorService = $paginatorService;
    }

    public function show($name) {

        $category = $this->categoryRepository->getCategoryByName($name);

        $categories = $this->categoryService->getCategoryNameWithParentName($category);

        $seo = [
            "title" => 'Статьи в категории '.$category->displayname,
            "description" => 'Все статьи в категории '.$category->displayname,
        ];

        $posts = $this->postRepository->getPaginatedPostsByCategory($category, true);

        foreach ($posts as $post) {
            $this->postService->countPostComments($post);
            $this->postService->countPostRating($post);
        }

        $pages = $this->paginatorService->calculatePages($posts);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        $categoryName = $category->name;

        return view('category.show', compact('seo', 'posts', 'categories', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage', 'categoryName'));
    }

    public function paginate($name, $id) {

        $category = $this->categoryRepository->getCategoryByName($name);

        $categories = $this->categoryService->getCategoryNameWithParentName($category);

        $seo = [
            "title" => 'Статьи в категории '.$category->displayname.'. Страница - '.$id.'.',
            "description" => 'Статьи в категории '.$category->displayname.'. Страница - '.$id.'.',
        ];

        $posts = $this->postRepository->getPaginatedPostsByCategory($category, false, $id);

        foreach ($posts as $post) {
            $this->postService->countPostComments($post);
            $this->postService->countPostRating($post);
        }

        $pages = $this->paginatorService->calculatePages($posts);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        $categoryName = $category->name;

        return view('category.show', compact('seo', 'posts', 'categories', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage', 'categoryName'));
    }
}