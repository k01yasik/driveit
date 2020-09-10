<?php

namespace App\Http\Controllers;

use App\Services\PostService;

class TurboController extends Controller
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
                'link' => 'https://'.config('app.name').'/posts/'.$post['slug'],
                'name' => $post['name'],
                'image' => $post['image_path'],
                'caption' => $post['caption'],
            ]);
        }


        return response()->view('turbo.index', ['data' => $data], 200)
            ->header('Content-Type', 'application/xml;charset=UTF-8');
    }
}
