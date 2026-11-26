<?php

namespace App\Repositories;

use App\Post;
use App\Rating;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RatingRepository implements RatingRepositoryInterface
{
    public function toggle(int $postId, int $userId): array
    {
        return DB::transaction(function () use ($postId, $userId): array {
            $post = Post::lockForUpdate()->findOrFail($postId);
            abort_unless($post->isPublished(), 404);

            $vote = Rating::where('post_id', $postId)->where('user_id', $userId)->first() ?? new Rating();
            $vote->post_id = $postId;
            $vote->user_id = $userId;
            $vote->rating = (int) $vote->rating === 1 ? 0 : 1;
            $vote->save();

            return ['count' => $this->countActiveVotes($postId), 'voted' => $vote->rating === 1];
        }, 3);
    }

    public function paginateTopPosts(CarbonInterface $from, CarbonInterface $until, int $perPage): LengthAwarePaginator
    {
        $votes = Rating::query()->where('rating', 1)->whereBetween('updated_at', [$from, $until])
            ->selectRaw('post_id, COUNT(*) AS period_rating_count')
            ->groupBy('post_id');

        return Post::query()->where('posts.is_published', true)->whereNull('posts.archived_at')
            ->joinSub($votes, 'period_votes', 'period_votes.post_id', '=', 'posts.id')
            ->with(['user.profile', 'categories', 'rating', 'comments'])
            ->orderByDesc('period_votes.period_rating_count')->orderByDesc('posts.date_published')->orderByDesc('posts.id')
            ->paginate($perPage, ['posts.*', 'period_votes.period_rating_count']);
    }

    public function countActiveVotes(int $postId): int
    {
        return Rating::where('post_id', $postId)->where('rating', 1)->count();
    }
}
