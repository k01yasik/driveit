<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\PostService;
use App\Services\SeoService;

class SearchController extends Controller
{
    protected SeoService $seoService;
    protected PostService $postService;

    public function __construct(SeoService $seoService, PostService $postService)
    {
        $this->seoService = $seoService;
        $this->postService = $postService;
    }

    public function index(SearchRequest $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $data = $request->validated();

        $query = clean($data['search']);

        $searches = $this->postService->search($query);

        return view('search.index', compact('seo', 'searches'));
    }
}
