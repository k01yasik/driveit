<?php

namespace App\Repositories\Interfaces;

interface FavoriteRepositoryInterface
{
    public function vote(int $imageId): int;

    public function delete(int $imageId): void;
}