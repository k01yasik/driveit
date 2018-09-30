<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Services\CommentService;
use App\Services\PaginateService;
use App\Services\PostSortService;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    protected $seoService;
    protected $commentService;
    protected $paginateService;
    protected $postSortService;

    public function __construct(SeoService $seoService, CommentService $commentService, PaginateService $paginateService, PostSortService $postSortService)
    {
        $this->seoService = $seoService;
        $this->commentService = $commentService;
        $this->paginateService = $paginateService;
        $this->postSortService = $postSortService;
    }

    public function home(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);
        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->take(10)->get();

        return view('page.home', compact('seo', 'posts'));
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function paginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10, ['*'], 'page', $id);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function list(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        $name = $request->route()->getName();

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

        $data = $this->paginateService->paginationData(10, 1, url()->current(), $posts->count());

        if ($name == 'posts.rated') {

            $posts = $this->postSortService->sortedBy($posts, 'posts.rated');

            $posts = $posts->slice( 0, $data['perPage']);

        } else if ($name == 'posts.views') {

            $posts = $this->postSortService->sortedBy($posts, 'posts.views');

            $posts = $posts->slice(0, $data['perPage']);

        } else {

            $posts = $this->postSortService->sortedBy($posts, 'posts.comments');

            $posts = $posts->slice(0, $data['perPage']);

        }

        return view('posts.list', compact('seo', 'posts', 'data'));
    }

    public function commentsPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

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

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

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

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

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

    public function show($slug)
    {
        $post = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where([['slug', $slug], ['is_published', 1]])->firstOrFail();

        $post->increment('views');

        $seo = [
            "title" => $post->title,
            "description" => $post->description,
            "image" => $post->image_path,
            "type" => 'article'
        ];

        $authenticated = Auth::check();
        $sortedComments = $this->commentService->sortComments($post->id);

        return view('posts.show', compact('seo', 'post', 'sortedComments', 'authenticated'));
    }
}