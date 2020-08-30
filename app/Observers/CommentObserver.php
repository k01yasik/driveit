<?php

namespace App\Observers;

use App\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
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

    /**
     * Handle the comment "updated" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        Cache::forget('latest-posts');
        Cache::forget('paginated-posts');
        Cache::forget('comments_verified');
        Cache::forget('comments_not_verified');
        Cache::forget('comment_'.$comment->id);
    }

    public function saved(Comment $comment)
    {
        Cache::forget('latest-posts');
        Cache::forget('paginated-posts');
        Cache::forget('comments_verified');
        Cache::forget('comments_not_verified');
        Cache::forget('comment_'.$comment->id);
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        Cache::forget('comment_'.$comment->id);
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
