<?php

namespace App\Services;

use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Post;

class RatingService
{
    protected RatingRepositoryInterface $ratingRepository;

    public function __construct(RatingRepositoryInterface $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function toggleRating(array $post): void {
        if ($post['rating'] === 0) {
            $this->ratingRepository->increaseRating($post['id']);
        } else {
            $this->ratingRepository->decreaseRating($post['id']);
        }
    }

    public function calculatePostRating(int $post_id): int {
        $i = 0;

        $ratings = $this->ratingRepository->getAllRatingsForPost($post_id);

        foreach ($ratings as $rating) {
            if ($rating->rating === 1) {
                $i+=1;
            }
        }

        return $i;
    }

    public function getPostRatingByUser(int $postId, int $userId): array
    {
        return $this->getPostRatingByUser($postId, $userId);
    }

    public function store(int $postId, int $userId): void
    {
        $this->ratingRepository->store($postId, $userId);
    }
}