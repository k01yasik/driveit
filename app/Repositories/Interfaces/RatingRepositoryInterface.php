<?php

namespace App\Repositories\Interfaces;

interface RatingRepositoryInterface
{
    public function toggle(int $postId, int $userId): int;

    public function countActiveVotes(int $postId): int;
}
