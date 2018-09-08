<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use Illuminate\Http\Request;
use App\Services\SeoService;

class PostController extends Controller
{
    protected $seoService;
    protected $commentService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function create(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        return view('admin.posts.create', compact('seo'));
    }

    public function store(PostStore $request)
    {

    }
}
