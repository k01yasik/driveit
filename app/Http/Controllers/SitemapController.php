<?php

namespace App\Http\Controllers;

use App\Repositories\CachedPostRepository;

class SitemapController extends Controller
{
    protected $postRepository;

    public function __construct(CachedPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $data = [];

        $posts = $this->postRepository->getPostsForSitemap();

        foreach ($posts as $post) {
            array_push($data, [
                'link' => 'https://web-rookie.ru/posts/'.$post->slug,
            ]);
        }

        return response()->view('sitemap.index', ['data' => $data], 200)
            ->header('Content-Type', 'application/xml;charset=UTF-8');
    }
}