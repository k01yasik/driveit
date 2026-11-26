<?php

namespace App\Observers;

use App\Repositories\CachedPostRepository;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;

class RatingObserver implements ShouldHandleEventsAfterCommit
{
    public function saved(): void
    {
        Cache::forget('latest-posts');
        Cache::forget('posts-published-this-month');
        CachedPostRepository::invalidateListings();
    }

    public function deleted(): void
    {
        $this->saved();
    }
}
