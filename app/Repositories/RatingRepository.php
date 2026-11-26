<?php

namespace App\Repositories;

use App\Post;
use App\Rating;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RatingRepository implements RatingRepositoryInterface
{
    public function toggle(int $postId, int $userId): int
    {
        return DB::transaction(function () use ($postId, $userId): int {
            $post = Post::lockForUpdate()->findOrFail($postId);
            abort_unless($post->isPublished(), 404);

            $vote = Rating::where('post_id', $postId)->where('user_id', $userId)->first() ?? new Rating();
            $vote->post_id = $postId;
            $vote->user_id = $userId;
            $vote->rating = (int) $vote->rating === 1 ? 0 : 1;
            $vote->save();

            return $this->countActiveVotes($postId);
        }, 3);
    }

    public function countActiveVotes(int $postId): int
    {
        return Rating::where('post_id', $postId)->where('rating', 1)->count();
    }
}
