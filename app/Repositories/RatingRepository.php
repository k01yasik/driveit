<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Rating;
use App\Post;

class RatingRepository implements RatingRepositoryInterface
{

    public function getPostRatingByUser(int $postId, int $userId): array
    {
        return Rating::where([['post_id', $postId], ['user_id', $userId]])->first()->toArray();
    }

    public function store(int $postId, int $userId): void
    {
        $rating = new Rating;
        $rating->user_id = $userId;
        $rating->post_id = $postId;
        $rating->rating = 1;
        $rating->save();
    }

    public function getAllRatingsForPost(int $postId): array
    {
        return Post::find($postId)->rating()->get()->toArray();
    }

    public function increaseRating(int $postId): void
    {
        $rating = Rating::wherePostId($postId)->first();
        $rating->rating += $rating->rating;
        $rating->save();
    }

    public function decreaseRating(int $postId): void
    {
        $rating = Rating::wherePostId($postId)->first();
        $rating->rating -= $rating->rating;
        $rating->save();
    }
}