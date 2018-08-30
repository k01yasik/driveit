<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\SeoService;
use App\Post;

class PageController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function home(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);
        /*$posts = Cache::remember('all-posts', 60, function () {
            return Post::with(['user', 'categories', 'user.profile'])->take(10)->get();
        });*/

        $posts = Post::with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('date_published')->take(10)->get();

        return view('page.home', compact('seo', 'posts'));
    }

    public function list(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        return view('posts.list', compact('seo'));
    }

    public function about(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        return view('page.about', compact('seo'));
    }

    public function rules(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        return view('page.rules', compact('seo'));
    }

    public function post($slug)
    {
        $post = Post::with(['user', 'categories', 'user.profile'])->where('slug', $slug)->firstOrFail();

        $post->increment('views');

        $seo = [
            "title" => $post->title,
            "description" => $post->description,
        ];
        return view('posts.show', compact('seo', 'post'));
    }
}
