<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class TurboController extends Controller
{
    public function index()
    {
        $data = [];
        $posts = Post::where('is_published', 1)->orderByDesc('date_published')->get();

        foreach ($posts as $post) {
            array_push($data, [
                'link' => 'https://driveitwith.me/posts/'.$post->slug,
                'name' => $post->name,
                'image' => $post->image_path,
                'caption' => $post->caption,
            ]);
        }


        return response()->view('turbo.index', ['data' => $data], 200)
            ->header('Content-Type', 'application/xml;charset=UTF-8');
    }
}
