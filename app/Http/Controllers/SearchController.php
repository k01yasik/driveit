<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Post;
use App\Services\SeoService;

class SearchController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index(SearchRequest $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $data = $request->validated();

        $query = clean($data['search']);

        $searches = Post::search($query)->paginate(10)->load(['user', 'categories', 'user.profile']);

        return view('search.index', compact('seo', 'searches'));
    }
}
