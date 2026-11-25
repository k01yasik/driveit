<?php

namespace App\Observers;

use App\Repositories\CachedPostRepository;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;

class PostObserver implements ShouldHandleEventsAfterCommit
{
    public function saved(): void
    {
        Cache::forget('latest-posts');
        Cache::forget('posts_count_cart');
        Cache::forget('posts-for-sitemap');
        Cache::forget('best-comments-by-month');
        CachedPostRepository::invalidateListings();
    }

    public function deleted(): void
    {
        $this->saved();
    }
}
