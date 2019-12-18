<?php

namespace App\Http\Controllers;

use App\Repositories\CachedPostRepository;

class TurboController extends Controller
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
                'link' => 'https://'.config('app.name').'/posts/'.$post->slug,
                'name' => $post->name,
                'image' => $post->image_path,
                'caption' => $post->caption,
            ]);
        }


        return response()->view('turbo.index', ['data' => $data], 200)
            ->header('Content-Type', 'application/xml;charset=UTF-8');
    }
}
