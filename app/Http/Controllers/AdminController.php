<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Post;

class AdminController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        return view('admin.users');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function posts(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::orderByDesc('id')->get();

        return view('admin.posts', compact('seo', 'posts'));
    }

    public function comments()
    {
        return view('admin.comments');
    }

    public function seo()
    {
        return view('admin.seo');
    }
}
