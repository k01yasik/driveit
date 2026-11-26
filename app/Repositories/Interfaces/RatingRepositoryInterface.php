<?php

namespace App\Repositories\Interfaces;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RatingRepositoryInterface
{
    /** @return array{count: int, voted: bool} */
    public function toggle(int $postId, int $userId): array;

    public function paginateTopPosts(CarbonInterface $from, CarbonInterface $until, int $perPage): LengthAwarePaginator;

    public function countActiveVotes(int $postId): int;
}
