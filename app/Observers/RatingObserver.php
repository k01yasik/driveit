<?php

namespace App\Observers;

use App\Rating;
use App\Services\PostService;
use Illuminate\Support\Facades\Cache;

class RatingObserver
{
    /**
     * Handle the rating "updated" event.
     *
     * @param  \App\Rating  $rating
     * @return void
     */
    public function updated(Rating $rating)
    {

    }

    public function saved(PostService $postService)
    {
        Cache::forget('latest-posts');
        Cache::forget('top-posts');

        $pages = $postService->getPagesCount();

        for ($i = 1; $i <= $pages; $i++) {
            Cache::forget('paginated-posts-'.$i);
        }
    }

    public function created(Rating $rating)
    {
        Cache::forget('latest-posts');
    }

    /**
     * Handle the rating "deleted" event.
     *
     * @param  \App\Rating  $rating
     * @return void
     */
    public function deleted(Rating $rating)
    {
        //
    }

    /**
     * Handle the rating "restored" event.
     *
     * @param  \App\Rating  $rating
     * @return void
     */
    public function restored(Rating $rating)
    {
        //
    }

    /**
     * Handle the rating "force deleted" event.
     *
     * @param  \App\Rating  $rating
     * @return void
     */
    public function forceDeleted(Rating $rating)
    {
        //
    }
}
