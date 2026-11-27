<?php

namespace App\Observers;

use App\Comment;
use App\Repositories\CachedPostRepository;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;

class CommentObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        //
    }

    public function saved(Comment $comment)
    {
        Cache::forget('latest-posts');
        Cache::forget('comments_verified');
        Cache::forget('comments_not_verified');
        Cache::forget('comment_'.$comment->id);
        CachedPostRepository::invalidateListings();
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        $this->saved($comment);
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
