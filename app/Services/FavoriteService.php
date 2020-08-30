<?php

namespace App\Services;


use App\Repositories\Interfaces\FavoriteRepositoryInterface;

class FavoriteService
{
    protected $favoriteRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function getFavCountForImage($imageId): int
    {
        return $this->favoriteRepository->getFavCountForImage($imageId);
    }

    public function vote(int $userId, int $imageId): void
    {
        $this->favoriteRepository->add($userId, $imageId);
    }

    public function removeVote(int $userId, int $imageId): void
    {
        $this->favoriteRepository->removeVote($userId, $imageId);
    }

    public function delete(int $imageId): void
    {
        $this->favoriteRepository->delete($imageId);
    }
}