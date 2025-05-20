<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\{
    PostService,
    SeoService,
    CommentService,
    SuggestsService,
    PaginatorService,
    PostSortService
};
use App\Services\SortService\Interfaces\SortFactory;
use App\DTO\CommentDTO;
use Illuminate\Http\Request;
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
        private SortFactory $sortFactory,
        private PostSortService $postSortService
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
        $posts = $this->postService->getAllPosts();
        $posts = $this->sortFactory->createPostSortByRating()->sort($posts);
        $posts = $this->postService->paginatePosts(array_slice($posts, 0, config('pagination.postsPerPage')), 1);

        return $this->renderSortedPostsView(
            $request,
            $posts,
            __('Best posts by rating')
        );
    }

    public function bestComments(Request $request): View
    {
        $posts = $this->postService->getAllPosts();
        $posts = $this->sortFactory->createPostSortByComments()->sort($posts);
        $posts = $this->postService->paginatePosts(array_slice($posts, 0, config('pagination.postsPerPage')), 1);

        return $this->renderSortedPostsView(
            $request,
            $posts,
            __('Best posts by comments')
        );
    }

    public function bestCommentsByMonth(Request $request): View
    {
        return view('posts.best-comments', [
            'seo' => $this->seoService->getSeoData($request),
            'posts' => $this->postSortService->getMonthlyTopByComments(),
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

    public function notFound(Request $request): View
    {
        return view('errors.404');
    }

    public function storeComment(Request $request): array
    {
        $validated = $request->validate([
            'post' => 'required|integer',
            'message' => 'required|string|max:5000',
            'level' => 'required|integer',
            'parent' => 'nullable|integer'
        ]);

        $commentDTO = new CommentDTO(
            postId: (int)$validated['post'],
            message: (string)$validated['message'],
            level: (int)$validated['level'],
            parentId: isset($validated['parent']) ? (int)$validated['parent'] : null
        );

        return $this->commentService->store($commentDTO)->toArray();
    }

    private function getSuggestedPosts(array $post): array
    {
        $suggestIds = $this->suggestsService->getSuggestsIds($post);
        return $this->postService->getPostsByIds($suggestIds);
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

        $posts = $this->postService->getAllPosts();
        $posts = $this->sortFactory->$sortMethod()->sort($posts);
        $posts = $this->postService->paginatePosts(
            array_slice($posts, $offset, $postsPerPage),
            $id
        );

        return $this->renderSortedPostsView(
            $request,
            $posts,
            $breadcrumb
        );
    }

    private function renderSortedPostsView(
        Request $request,
        array $posts,
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

    private function getPaginationData(array $posts): array
    {
        [$previous, $next, $last] = $this->paginatorService->calculatePages($posts);
        
        return [
            'posts' => $posts,
            'previousNumberPage' => $previous,
            'nextNumberPage' => $next,
            'lastNumberPage' => $last
        ];
    }
}
