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

class PageController extends Controller
{
    protected SeoService $seoService;
    protected CommentService $commentService;
    protected PaginateService $paginateService;
    protected PaginatorService $paginatorService;
    protected PostSortService $postSortService;
    protected PostService $postService;
    protected SuggestsService $suggestsService;

    public function __construct(
        SeoService $seoService,
        CommentService $commentService,
        PaginateService $paginateService,
        PostSortService $postSortService,
        PostService $postService,
        PaginatorService $paginatorService,
        SuggestsService $suggestsService
    )
    {
        $this->seoService = $seoService;
        $this->commentService = $commentService;
        $this->paginateService = $paginateService;
        $this->postSortService = $postSortService;
        $this->postService = $postService;
        $this->paginatorService = $paginatorService;
        $this->suggestsService = $suggestsService;
    }

    public function home(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postService->getAllPublishedPosts();

        return view('page.home', compact('seo', 'posts'));
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postService->getAllPublishedPosts();

        $pages = $this->paginatorService->calculatePages($posts);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function paginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postService->getPaginatedPostsWithoutCache($id);

        foreach ($posts as $post) {

            $post->rating_count = $this->postService->countPostRating($post->rating->toArray());
            $post->comments_count = $this->postService->countPostComments($post->comments->toArray());;
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

        $posts = $this->postService->getAllPosts();

        foreach ($posts as $post) {

            $post->rating_count = $this->postService->countPostRating($post->rating->toArray());
            $post->comments_count = $this->postService->countPostComments($post->comments->toArray());;
        }

        $data = $this->paginateService->paginationData(10, 1, url()->current(), count($posts));

        $posts = $this->postSortService->getSlicedData($name, $posts, $data["perPage"]);

        return view('posts.list', compact('seo', 'posts', 'data'));
    }

    public function commentsPaginate($id, Request $request)
    {
        list($seo, $posts) = $this->handler($request, $id);

        $data = $this->paginateService->paginationData(10, $id, config('app.url').'/best-comments', $posts->count());

        $posts = $this->postSortService->sortedBy($posts, 'posts.comments');

        $posts = $posts->slice($data['perPage'] * $id - $data['perPage'], $data['perPage']);

        return view('posts.list', compact('seo', 'posts', 'data'));
    }

    public function ratedPaginate($id, Request $request)
    {
        list($seo, $posts) = $this->handler($request, $id);

        $data = $this->paginateService->paginationData(10, $id, config('app.url').'/best-rated', $posts->count());

        $posts = $this->postSortService->sortedBy($posts, 'posts.rated');

        $posts = $posts->slice($data['perPage'] * $id - $data['perPage'], $data['perPage']);

        return view('posts.list', compact('seo', 'posts', 'data'));
    }

    public function viewsPaginate($id, Request $request)
    {
        list($seo, $posts) = $this->handler($request, $id);

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

    public function show($slug)
    {

        $post = $this->postService->getPostsForShow($slug);

        $post->rating_count = $this->postService->countPostRating($post['rating']->toArray());
        $post->comments_count = $this->postService->countPostComments($post['comments']->toArray());;

        $suggestIds = $this->suggestsService->getSuggestsIds($post);

        $suggestPosts = $this->postService->getSuggests($suggestIds);

        foreach ($suggestPosts as $pp) {

            $post->rating_count = $this->postService->countPostRating($post['rating']->toArray());
            $post->comments_count = $this->postService->countPostComments($post['comments']->toArray());;
        }

        $this->postService->incrementViews($post['id']);

        $seo = [
            "title" => $post['title'],
            "description" => $post['description'],
            "image" => $post['image_path'],
            "type" => 'article'
        ];

        $authenticated = Auth::check();
        $sortedComments = $this->commentService->sortComments($post['id']);

        return view('posts.show', compact('seo', 'post', 'sortedComments', 'authenticated', 'suggestPosts'));
    }

    public function notFound(Request $request)
    {
        return view('errors.404');
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    private function handler(Request $request, $id): array
    {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'] . '. Страница - ' . $id . '.';
        $seo['description'] = $seo['description'] . '. Страница - ' . $id . '.';

        $posts = $this->postService->getAllPosts();

        foreach ($posts as $post) {
            $post->rating_count = $this->postService->countPostRating($post->rating->toArray());
            $post->comments_count = $this->postService->countPostComments($post->comments->toArray());;
        }
        return array($seo, $posts);
    }
}