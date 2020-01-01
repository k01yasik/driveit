<?php

namespace App\Http\Controllers;

use App\Repositories\CachedPostRepository;
use App\Services\PaginatorService;
use App\Services\PostService;
use App\Services\SuggestsService;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Services\CommentService;
use App\Services\PaginateService;
use App\Services\PostSortService;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PageController extends Controller
{
    protected $seoService;
    protected $commentService;
    protected $paginateService;
    protected $paginatorService;
    protected $postSortService;
    protected $postService;
    protected $postRepository;
    protected $suggestsService;

    public function __construct(
        SeoService $seoService,
        CommentService $commentService,
        PaginateService $paginateService,
        PostSortService $postSortService,
        PostService $postService,
        CachedPostRepository $postRepository,
        PaginatorService $paginatorService,
        SuggestsService $suggestsService
    )
    {
        $this->seoService = $seoService;
        $this->commentService = $commentService;
        $this->paginateService = $paginateService;
        $this->postSortService = $postSortService;
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->paginatorService = $paginatorService;
        $this->suggestsService = $suggestsService;
    }

    public function home(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postRepository->getPaginatedPostsForPages();

        return view('page.home', compact('seo', 'posts'));
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postRepository->getPaginatedPostsForPages();

        $pages = $this->paginatorService->calculatePages($posts);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function paginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postRepository->getPaginatedPostsWithoutCache($id);

        foreach ($posts as $post) {

            $this->postService->countPostRating($post);
            $this->postService->countPostComments($post);
        }

        $pages = $this->paginatorService->calculatePages($posts);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function list(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        $name = $request->route()->getName();

        $posts = $this->postRepository->getPostCollection();

        foreach ($posts as $post) {

            $this->postService->countPostRating($post);
            $this->postService->countPostComments($post);
        }

        $data = $this->paginateService->paginationData(10, 1, url()->current(), $posts->count());

        $posts = $this->postSortService->getSlicedData($name, $posts, $data["perPage"]);

        return view('posts.list', compact('seo', 'posts', 'data'));
    }

    public function commentsPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postRepository->getPostCollection();

        foreach ($posts as $post) {

            $this->postService->countPostRating($post);
            $this->postService->countPostComments($post);
        }

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $data = $this->paginateService->paginationData(10, $id, config('app.url').'/best-comments', $posts->count());

        $posts = $this->postSortService->sortedBy($posts, 'posts.comments');

        $posts = $posts->slice($data['perPage'] * $id - $data['perPage'], $data['perPage']);

        return view('posts.list', compact('seo', 'posts', 'data'));
    }

    public function ratedPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postRepository->getPostCollection();

        foreach ($posts as $post) {

            $this->postService->countPostRating($post);
            $this->postService->countPostComments($post);
        }

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $data = $this->paginateService->paginationData(10, $id, config('app.url').'/best-rated', $posts->count());

        $posts = $this->postSortService->sortedBy($posts, 'posts.rated');

        $posts = $posts->slice($data['perPage'] * $id - $data['perPage'], $data['perPage']);

        return view('posts.list', compact('seo', 'posts', 'data'));
    }

    public function viewsPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postRepository->getPostCollection();

        foreach ($posts as $post) {

            $this->postService->countPostRating($post);
            $this->postService->countPostComments($post);
        }

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $data = $this->paginateService->paginationData(10, $id, config('app.url').'/best-views', $posts->count());

        $posts = $this->postSortService->sortedBy($posts, 'posts.views');

        $posts = $posts->slice($data['perPage'] * $id - $data['perPage'], $data['perPage']);

        return view('posts.list', compact('seo', 'posts', 'data'));
    }

    public function about(Request $request) {
        $seo = $this->seoService->getSeoData($request);

        return view('page.about', compact('seo'));
    }

    public function rules(Request $request) {
        $seo = $this->seoService->getSeoData($request);

        return view('page.rules', compact('seo'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {

        $post = $this->postRepository->getPostsForShow($slug);

        $this->postService->countPostRating($post);
        $this->postService->countPostComments($post);


        $suggest_ids = $this->suggestsService->getSuggestsIds($post);

        $suggest_posts = $this->postRepository->getSuggests($suggest_ids);

        foreach ($suggest_posts as $pp) {

            $this->postService->countPostRating($pp);
            $this->postService->countPostComments($pp);
        }

        $post->increment('views');

        event('eloquent.saved: App\Post', $post);

        $seo = [
            "title" => $post->title,
            "description" => $post->description,
            "image" => $post->image_path,
            "type" => 'article'
        ];

        $authenticated = Auth::check();
        $sortedComments = $this->commentService->sortComments($post->id);

        return view('posts.show', compact('seo', 'post', 'sortedComments', 'authenticated', 'suggest_posts'));
    }
}