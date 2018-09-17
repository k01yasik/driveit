<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Services\CommentService;
use App\Post;

class PageController extends Controller
{
    protected $seoService;
    protected $commentService;

    public function __construct(SeoService $seoService, CommentService $commentService)
    {
        $this->seoService = $seoService;
        $this->commentService = $commentService;
    }

    public function home(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);
        $posts = Post::with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('date_published')->take(10)->get();

        return view('page.home', compact('seo', 'posts'));
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10);

        return view('posts.index', compact('seo', 'posts'));

    }

    public function list(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        $name = $request->route()->getName();

        if ($name == 'posts.rated') {
            $posts = Post::with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('rating')->orderByDesc('date_published')->paginate(10);
        } else if ($name == 'posts.views') {
            $posts = Post::with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('views')->orderByDesc('date_published')->paginate(10);
        } else {
            $posts = Post::with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('comments')->orderByDesc('date_published')->paginate(10);
        }

        return view('posts.list', compact('seo', 'posts'));
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
        $post = Post::with(['user', 'categories', 'user.profile'])->where([['slug', $slug], ['is_published', 1]])->firstOrFail();

        $post->increment('views');

        $seo = [
            "title" => $post->title,
            "description" => $post->description,
            "image" => $post->image_path,
            "type" => 'article'
        ];

        $sortedComments = $this->commentService->sortComments($post->id);

        return view('posts.show', compact('seo', 'post', 'sortedComments'));
    }
}