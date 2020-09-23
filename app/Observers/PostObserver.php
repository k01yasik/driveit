<?php

namespace App\Observers;

use App\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    private PostService $postService;

    /**
     * PostObserver constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function created()
    {
    }

    public function updated()
    {
    }

    public function saved(Post $post)
    {
        Cache::forget('latest-posts');
        Cache::forget('posts_count_cart');
        Cache::forget('posts-for-sitemap');
        Cache::forget('top-posts');

        $pages = $this->postService->getPagesCount();

        for ($i = 1; $i <= $pages; $i++) {
            Cache::forget('paginated-posts-'.$i);
        }

    }

    public function deleted()
    {
    }

    public function restored()
    {
    }

    public function forceDeleted()
    {
    }
}
