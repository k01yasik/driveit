<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Rating;
use App\Post;

class RatingRepository implements RatingRepositoryInterface
{

    public function getUserRatingForPost(int $post_id, int $user_id): Model
    {
        return Rating::where([['post_id', $post_id], ['user_id', $user_id]])->firstOrFail();
    }

    public function store(int $post_id, int $user_id): void
    {
        $rating = new Rating;
        $rating->user_id = $user_id;
        $rating->post_id = $post_id;
        $rating->rating = 1;
        $rating->save();
    }

    public function getRatingCollectionForPost(int $post_id): Collection
    {
        return Post::find($post_id)->rating()->get();
    }
}