<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $posts = Post::take(10)->get();
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
        return view('posts.show');
    }
}
