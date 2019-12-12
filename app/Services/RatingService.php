<?php

namespace App\Services;

use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Post;

class RatingService
{
    protected $ratingRepository;

    public function __construct(RatingRepositoryInterface $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function toggleRating(Model $post): void {
        if ($post->rating === 0) {
            $post->increment('rating');
        } else {
            $post->decrement('rating');
        }
    }

    public function calculatePostRating(int $post_id): int {

        $i = 0;

        $newRating = $this->ratingRepository->getRatingCollectionForPost($post_id);

        foreach ($newRating as $new) {
            if ($new->rating === 1) {
                $i+=1;
            }
        }

        return $i;
    }
}