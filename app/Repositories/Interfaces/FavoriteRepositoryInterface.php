<?php

namespace App\Repositories\Interfaces;

interface FavoriteRepositoryInterface
{
    public function deleteAllForImage(int $imageId): void;
    
    public function getFavoritesCountForImage(int $imageId): int;
    
    public function removeFavorite(int $userId, int $imageId): void;
    
    public function addFavorite(int $userId, int $imageId): void;
    
    public function userHasFavorite(int $userId, int $imageId): bool;
}
