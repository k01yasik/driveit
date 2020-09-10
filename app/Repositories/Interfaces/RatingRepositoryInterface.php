<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface RatingRepositoryInterface
{
    public function getPostRatingByUser(int $postId, int $userId): array;

    public function store(int $postId, int $userId): void;

    public function getAllRatingsForPost(int $postId): array;

    public function increaseRating(int $postId): void;

    public function decreaseRating(int $postId): void;
}