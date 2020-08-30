<?php

namespace App\Repositories\Interfaces;

interface FavoriteRepositoryInterface
{

    public function delete(int $imageId): void;

    public function getFavCountForImage(int $imageId): int;

    public function removeVote(int $userId, int $imageId): void;

    public function add(int $userId, int $imageId): void;
}