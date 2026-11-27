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
use App\Services\SortService\PostOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        private SuggestsService $suggestsService
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
        return $this->ranked($request, PostOrder::Rating);
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
        return $this->ranked($request, PostOrder::Comments);
    }

    public function bestCommentsByMonth(Request $request): View
    {
        $title = __('Best of the month by comments');
        try {
            $seo = $this->seoService->getSeoData($request);
        } catch (ModelNotFoundException) {
            $seo = ['title' => $title, 'description' => $title];
        }

        return view('posts.best-comments', [
            'seo' => $seo,
            'posts' => $this->postService->calculatePostStats($this->postService->getPostsByMonth()),
            'breadcrumb' => $title,
        ]);
    }

    public function bestViews(Request $request): View
    {
        return $this->ranked($request, PostOrder::Views);
    }

    public function commentsPaginate(int $id, Request $request): View
    {
        return $this->ranked($request, PostOrder::Comments, $id);
    }

    public function ratedPaginate(int $id, Request $request): View
    {
        return $this->ranked($request, PostOrder::Rating, $id);
    }

    public function viewsPaginate(int $id, Request $request): View
    {
        return $this->ranked($request, PostOrder::Views, $id);
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

    private function ranked(Request $request, PostOrder $order, int $page = 1): View
    {
        [$breadcrumb, $route, $pageRoute] = match ($order) {
            PostOrder::Rating => [__('Best posts by rating'), 'posts.rated', 'best.rated.paginate'],
            PostOrder::Comments => [__('Best posts by comments'), 'posts.comments', 'best.comments.paginate'],
            PostOrder::Views => [__('Best posts by views'), 'posts.views', 'best.views.paginate'],
        };

        return view('posts.list', array_merge(
            [
                'seo' => $this->seoService->getSeoData($request),
                'breadcrumb' => $breadcrumb,
                'rankingRoute' => $route,
                'rankingPageRoute' => $pageRoute,
            ],
            $this->getPaginationData($this->postService->paginateRankedPosts($order, $page))
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
