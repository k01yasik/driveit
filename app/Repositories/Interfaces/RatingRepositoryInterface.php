<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface RatingRepositoryInterface
{
    public function getUserRatingForPost(int $post_id, int $user_id): Model;

    public function store(int $post_id, int $user_id): void;

    public function getRatingCollectionForPost(int $post_id): Collection;
}