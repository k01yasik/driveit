<?php

namespace App\Services;

use App\Repositories\Interfaces\RatingRepositoryInterface;

class RatingService
{
    public function __construct(private RatingRepositoryInterface $ratingRepository)
    {
    }

    public function toggleRating(int $postId, int $userId): int
    {
        return $this->ratingRepository->toggle($postId, $userId);
    }

    public function calculatePostRating(int $postId): int
    {
        return $this->ratingRepository->countActiveVotes($postId);
    }
}
