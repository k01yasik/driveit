<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Post;
use App\Store;

class SitemapController extends Controller
{
    public function index()
    {
        $data = [];
        $store = [];

        $posts = Cache::rememberForever('posts-for-sitemap', function () {
            return Post::where('is_published', 1)->orderByDesc('date_published')->get();
        });

        $stores = Store::all();

        foreach ($posts as $post) {
            array_push($data, [
                'link' => 'https://driveitwith.me/posts/'.$post->slug,
            ]);
        }

        foreach ($stores as $s) {
            array_push($store, [
                'name' => $s->name,
            ]);
        }

        return response()->view('sitemap.index', ['data' => $data, 'store' => $store], 200)
            ->header('Content-Type', 'application/xml;charset=UTF-8');
    }
}