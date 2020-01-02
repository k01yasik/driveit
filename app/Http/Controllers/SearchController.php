<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Post;
use App\Repositories\CachedPostRepository;
use App\Services\PostService;
use App\Services\SeoService;

class SearchController extends Controller
{
    protected $seoService;
    protected $postRepository;

    public function __construct(SeoService $seoService, CachedPostRepository $postRepository)
    {
        $this->seoService = $seoService;
        $this->postRepository = $postRepository;
    }

    public function index(SearchRequest $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $data = $request->validated();

        $query = clean($data['search']);

        $searches = $this->postRepository->search($query);

        return view('search.index', compact('seo', 'searches'));
    }
}
