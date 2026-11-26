<?php

namespace App\Services;

use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RatingService
{
    public function __construct(private RatingRepositoryInterface $ratingRepository)
    {
    }

    public function toggleRating(int $postId, int $userId): int
    {
        return $this->toggleWithStatus($postId, $userId)['count'];
    }

    /** @return array{count: int, voted: bool} */
    public function toggleWithStatus(int $postId, int $userId): array
    {
        return $this->ratingRepository->toggle($postId, $userId);
    }

    public function topPosts(int $days, int $perPage): LengthAwarePaginator
    {
        $until = now()->toImmutable();

        return $this->ratingRepository->paginateTopPosts($until->subDays($days), $until, $perPage);
    }

    public function calculatePostRating(int $postId): int
    {
        return $this->ratingRepository->countActiveVotes($postId);
    }
}
