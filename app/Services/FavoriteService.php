<?php

namespace App\Services;

use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use App\Exceptions\FavoriteException;

class FavoriteService
{
    private FavoriteRepositoryInterface $favoriteRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function getFavoritesCountForImage(int $imageId): int
    {
        return $this->favoriteRepository->getFavoritesCountForImage($imageId);
    }

    public function addFavorite(int $userId, int $imageId): void
    {
        if ($this->favoriteRepository->userHasFavorite($userId, $imageId)) {
            throw FavoriteException::alreadyExists($userId, $imageId);
        }

        $this->favoriteRepository->addFavorite($userId, $imageId);
    }

    public function removeFavorite(int $userId, int $imageId): void
    {
        if (!$this->favoriteRepository->userHasFavorite($userId, $imageId)) {
            throw FavoriteException::notFound($userId, $imageId);
        }

        $this->favoriteRepository->removeFavorite($userId, $imageId);
    }

    public function deleteAllFavoritesForImage(int $imageId): void
    {
        $this->favoriteRepository->deleteAllForImage($imageId);
    }
}
