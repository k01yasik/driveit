<?php

namespace App\Http\Controllers;

use App\Services\PaginatorService;
use App\Services\PostService;
use App\Services\SuggestsService;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Services\CommentService;
use App\Services\PaginateService;
use App\Services\PostSortService;
use Illuminate\Support\Facades\Auth;
use App\Services\SortService\Interfaces\SortFactory;

class PageController extends Controller
{
    public function __construct(
        private SeoService $seoService,
        private CommentService $commentService,
        private PaginateService $paginateService,
        private PostSortService $postSortService,
        private PostService $postService,
        private PaginatorService $paginatorService,
        private SuggestsService $suggestsService,
        private SortFactory $sortFactory
    )
    {}

    public function home(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postService->getTopPosts(config('pagination.postsPerPage'));

        return view('page.home', compact('seo', 'posts'));
    }

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postService->getPostsForPage(1, config('pagination.postsPerPage'));

        $posts = $this->postService->calculatePostStats($posts);

        $posts = $this->postService->getPostsPaginator($posts, 1, config('pagination.postsPerPage'));

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function paginate($id, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postService->getPostsForPage($id, config('pagination.postsPerPage'));

        $posts = $this->postService->calculatePostStats($posts);

        $posts = $this->postService->getPostsPaginator($posts, $id, config('pagination.postsPerPage'));

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function bestRated(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        $url= url()->current();

        $breadcrumb = __('Best posts by rating');

        $posts = $this->postService->getAllPosts();

        $posts = $this->postService->calculatePostStats($posts);

        $posts = $this->sortFactory->createPostSortByRating()->sort($posts);

        $posts = array_slice($posts, 0, config('pagination.postsPerPage'));

        $posts = $this->postService->getPostsPaginator($posts, 1, config('pagination.postsPerPage'));

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        return view('posts.list', compact('seo', 'posts', 'url', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'breadcrumb'));
    }

    public function bestComments(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        $url= url()->current();

        $breadcrumb = __('Best posts by comments');

        $posts = $this->postService->getAllPosts();

        $posts = $this->postService->calculatePostStats($posts);

        $posts = $this->sortFactory->createPostSortByComments()->sort($posts);

        $posts = array_slice($posts, 0, config('pagination.postsPerPage'));

        $posts = $this->postService->getPostsPaginator($posts, 1, config('pagination.postsPerPage'));

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        return view('posts.list', compact('seo', 'posts', 'url', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'breadcrumb'));
    }

    public function bestCommentsByMonth(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        $breadcrumb = __('Best of the month by comments');

        $posts = $this->postService->getPostsByMonth();

        $posts = $this->postService->calculatePostStats($posts);

        $posts = $this->sortFactory->createPostSortByComments()->sort($posts);

        return view('posts.best-comments', compact('seo', 'posts', 'breadcrumb'));
    }

    public function bestViews(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        $url= url()->current();

        $breadcrumb = __('Best posts by views');

        $posts = $this->postService->getPostsSortedByViews(1, config('pagination.postsPerPage'));

        $posts = $this->postService->calculatePostStats($posts);

        $posts = $this->postService->getPostsPaginator($posts, 1, config('pagination.postsPerPage'));

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        return view('posts.list', compact('seo', 'posts', 'url', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'breadcrumb'));
    }

    public function commentsPaginate($id, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $breadcrumb = __('Best posts by comments');

        list($postsPerPage, $offset, $seo, $url, $posts) = $this->prepareData($id, $request);

        $posts = $this->sortFactory->createPostSortByComments()->sort($posts);

        $posts = array_slice($posts, $offset, $postsPerPage);

        $posts = $this->postService->getPostsPaginator($posts, $id, $postsPerPage);

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        return view('posts.list', compact('seo', 'posts', 'url', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'breadcrumb'));
    }

    public function ratedPaginate($id, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $breadcrumb = __('Best posts by rating');

        list($postsPerPage, $offset, $seo, $url, $posts) = $this->prepareData($id, $request);

        $posts = $this->sortFactory->createPostSortByRating()->sort($posts);

        $posts = array_slice($posts, $offset, $postsPerPage);

        $posts = $this->postService->getPostsPaginator($posts, $id, $postsPerPage);

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        return view('posts.list', compact('seo', 'posts', 'url', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'breadcrumb'));
    }

    public function viewsPaginate($id, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $breadcrumb = __('Best posts by views');

        $postsPerPage = config('pagination.postsPerPage');

        $seo = $this->getSeoData($request, $id);

        $url = $this->getUrlBreadcrumb($request);

        $posts = $this->postService->getPostsSortedByViews($id, $postsPerPage);

        $posts = $this->postService->calculatePostStats($posts);

        $posts = $this->postService->getPostsPaginator($posts, $id, $postsPerPage);

        list($previousNumberPage, $nextNumberPage, $lastNumberPage) = $this->paginatorService->calculatePages($posts);

        return view('posts.list', compact('seo', 'posts', 'url', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'breadcrumb'));
    }

    public function about(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        return view('page.about', compact('seo'));
    }

    public function rules(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $seo = $this->seoService->getSeoData($request);

        return view('page.rules', compact('seo'));
    }

    public function show($slug): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $post = $this->postService->getPostsForShow($slug);

        $post = $this->postService->calculatePostStats($post);

        $post = $post[0];

        $suggestIds = $this->suggestsService->getSuggestsIds($post);

        $suggestPosts = $this->postService->getSuggests($suggestIds);

        $suggestPosts = $this->postService->calculatePostStats($suggestPosts);

        $this->postService->incrementViews($post['id']);

        $seo = [
            "title" => $post['title'],
            "description" => $post['description'],
            "image" => $post['image_path'],
            "type" => "article"
        ];

        $authenticated = Auth::check();

        $sortedComments = $this->commentService->sortComments($post['id']);

        return view('posts.show', compact('seo', 'post', 'sortedComments', 'authenticated', 'suggestPosts'));
    }

    public function notFound(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('errors.404');
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    private function getSeoData(Request $request, $id): array
    {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'] . '. Страница - ' . $id . '.';
        $seo['description'] = $seo['description'] . '. Страница - ' . $id . '.';
        return $seo;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getUrlBreadcrumb(Request $request): string
    {
        return url('/') . '/' . $request->segment(1);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    private function prepareData($id, Request $request): array
    {
        $postsPerPage = config('pagination.postsPerPage');

        $offset = ($id - 1) * $postsPerPage;

        $seo = $this->getSeoData($request, $id);

        $url = $this->getUrlBreadcrumb($request);

        $posts = $this->postService->getAllPosts();

        $posts = $this->postService->calculatePostStats($posts);

        return array($postsPerPage, $offset, $seo, $url, $posts);
    }
}