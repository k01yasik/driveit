<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    /**
     * @param int $id
     */
    public function publish(int $id): void;

    public function store(array $data): array;

    public function getCommentsVerifiedCount(): int;

    public function getCommentsNotVerifiedCount(): int;

    /**
     * @param bool $isStart
     * @param int|null $id
     * @return Paginator
     */
    public function getPaginatedComments(bool $isStart, int $id = null): Paginator;

    public function getUnpublishedComments(): Collection;
}