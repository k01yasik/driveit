<?php

namespace App\Http\Controllers;

use App\Services\PostService;

class SitemapController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $data = [];

        $posts = $this->postService->getPostsForSitemap();

        foreach ($posts as $post) {
            array_push($data, [
                'link' => 'https://web-rookie.ru/posts/'.$post['slug'],
            ]);
        }

        return response()->view('sitemap.index', ['data' => $data], 200)
            ->header('Content-Type', 'application/xml;charset=UTF-8');
    }
}