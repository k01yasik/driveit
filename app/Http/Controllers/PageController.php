<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\{
    PostService,
    RatingService,
    SeoService,
    CommentService,
    SuggestsService,
    PaginatorService
};
use App\Services\SortService\Interfaces\SortFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function __construct(
        private SeoService $seoService,
        private CommentService $commentService,
        private PostService $postService,
        private PaginatorService $paginatorService,
        private SuggestsService $suggestsService,
        private SortFactory $sortFactory
    ) {}

    public function home(Request $request): View
    {
        return view('page.home', [
            'seo' => $this->seoService->getSeoData($request),
            'posts' => $this->postService->getTopPosts(config('pagination.postsPerPage'))
        ]);
    }

    public function index(Request $request): View
    {
        $posts = $this->postService->getPostsForPage(1, config('pagination.postsPerPage'));
        $posts = $this->postService->calculateAndPaginate($posts, 1);

        return view('posts.index', array_merge(
            ['seo' => $this->seoService->getSeoData($request)],
            $this->getPaginationData($posts)
        ));
    }

    public function paginate(int $id, Request $request): View
    {
        $posts = $this->postService->getPostsForPage($id, config('pagination.postsPerPage'));
        $posts = $this->postService->calculateAndPaginate($posts, $id);

        return view('posts.index', array_merge(
            ['seo' => $this->seoService->getSeoData($request)],
            $this->getPaginationData($posts)
        ));
    }

    public function bestRated(Request $request): View
    {
        return $this->paginateSortedPosts(1, $request, 'createPostSortByRating', __('Best posts by rating'));
    }

    public function bestRatedByPeriod(string $period, RatingService $ratingService): View
    {
        $week = $period === 'week';
        $title = $week ? __('Top posts of the week') : __('Top posts of the month');
        $posts = $ratingService->topPosts($week ? 7 : 30, config('pagination.postsPerPage'));
        $posts->through(fn ($post) => $this->postService->calculatePostStats($post->toArray()));

        return view('posts.list', [
            'seo' => ['title' => $title, 'description' => $title],
            'breadcrumb' => $title,
            'posts' => $posts,
            'ratingPeriod' => $period,
        ]);
    }

    public function bestComments(Request $request): View
    {
        return $this->paginateSortedPosts(1, $request, 'createPostSortByComments', __('Best posts by comments'));
    }

    public function bestCommentsByMonth(Request $request): View
    {
        $posts = $this->postService->calculatePostStats($this->postService->getPostsByMonth());
        $posts = $this->sortFactory->createPostSortByComments()->sort($posts);

        return view('posts.best-comments', [
            'seo' => $this->seoService->getSeoData($request),
            'posts' => $posts,
            'breadcrumb' => __('Best of the month by comments')
        ]);
    }

    public function bestViews(Request $request): View
    {
        $posts = $this->postService->getPostsSortedByViews(1, config('pagination.postsPerPage'));
        $posts = $this->postService->calculateAndPaginate($posts, 1);

        return $this->renderSortedPostsView(
            $request,
            $posts,
            __('Best posts by views')
        );
    }

    public function commentsPaginate(int $id, Request $request): View
    {
        return $this->paginateSortedPosts(
            $id,
            $request,
            'createPostSortByComments',
            __('Best posts by comments')
        );
    }

    public function ratedPaginate(int $id, Request $request): View
    {
        return $this->paginateSortedPosts(
            $id,
            $request,
            'createPostSortByRating',
            __('Best posts by rating')
        );
    }

    public function viewsPaginate(int $id, Request $request): View
    {
        $posts = $this->postService->getPostsSortedByViews($id, config('pagination.postsPerPage'));
        $posts = $this->postService->calculateAndPaginate($posts, $id);

        return $this->renderSortedPostsView(
            $request,
            $posts,
            __('Best posts by views')
        );
    }

    public function about(Request $request): View
    {
        return view('page.about', [
            'seo' => $this->seoService->getSeoData($request)
        ]);
    }

    public function rules(Request $request): View
    {
        return view('page.rules', [
            'seo' => $this->seoService->getSeoData($request)
        ]);
    }

    public function show(string $slug): View
    {
        $post = $this->postService->getPostBySlugWithUserData($slug);
        $this->postService->incrementViews($post['id']);

        return view('posts.show', [
            'seo' => $this->getPostSeoData($post),
            'post' => $post,
            'sortedComments' => $this->commentService->getNestedComments($post['id']),
            'authenticated' => Auth::check(),
            'suggestPosts' => $this->getSuggestedPosts($post)
        ]);
    }

    public function notFound(): Response
    {
        return response()->view('errors.404', [], 404);
    }

    private function getSuggestedPosts(array $post): array
    {
        $suggestIds = $this->suggestsService->getSuggestsIds($post);
        return $this->postService->getSuggestsWithStats($suggestIds);
    }

    private function getPostSeoData(array $post): array
    {
        return [
            "title" => $post['title'],
            "description" => $post['description'],
            "image" => $post['image_path'],
            "type" => "article"
        ];
    }

    private function paginateSortedPosts(
        int $id,
        Request $request,
        string $sortMethod,
        string $breadcrumb
    ): View {
        $postsPerPage = config('pagination.postsPerPage');
        $offset = ($id - 1) * $postsPerPage;

        $posts = $this->postService->getAllPostsWithStats();
        $posts = $this->sortFactory->$sortMethod()->sort($posts);
        $posts = $this->postService->getPostsPaginator(
            array_slice($posts, $offset, $postsPerPage),
            $id,
            $postsPerPage
        );

        return $this->renderSortedPostsView(
            $request,
            $posts,
            $breadcrumb
        );
    }

    private function renderSortedPostsView(
        Request $request,
        LengthAwarePaginator $posts,
        string $breadcrumb
    ): View {
        return view('posts.list', array_merge(
            [
                'seo' => $this->seoService->getSeoData($request),
                'url' => url()->current(),
                'breadcrumb' => $breadcrumb
            ],
            $this->getPaginationData($posts)
        ));
    }

    private function getPaginationData(LengthAwarePaginator $posts): array
    {
        $pages = $this->paginatorService->calculatePages($posts);
        
        return [
            'posts' => $posts,
            'previousNumberPage' => $pages['previous'],
            'nextNumberPage' => $pages['next'],
            'lastNumberPage' => $pages['last']
        ];
    }
}
