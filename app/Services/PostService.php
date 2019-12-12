<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class PostService
{

    /**
     * @param Model $post
     */
    public function countPostRating(Model $post): void
    {
        $post->rating_count = 0;

        foreach ($post->rating as $r) {
            if ($r->rating === 1) {
                $post->rating_count = $post->rating_count + 1;
            }
        }
    }


    /**
     * @param Model $post
     */
    public function countPostComments(Model $post): void
    {
        $post->comments_count = 0;

        foreach ($post->comments as $c) {
            if ($c->is_verified === 1) {
                $post->comments_count = $post->comments_count + 1;
            }
        }
    }

}