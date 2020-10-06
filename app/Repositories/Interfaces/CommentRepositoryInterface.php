<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;

interface CommentRepositoryInterface
{
    public function getById(int $id): array;

    public function update(array $comment): void;

    public function save(array $comment): array;

    public function getCommentsVerifiedCount(): int;

    public function getCommentsNotVerifiedCount(): int;

    public function getCommentsByPost(int $id): array;

    public function getPaginatedComments(bool $isStart, int $id = null): Paginator;

    public function getUnpublishedComments(): array;
}