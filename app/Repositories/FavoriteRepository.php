<?php

namespace App\Repositories;

use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use App\Favorite;
use App\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    public function deleteAllForImage(int $imageId): void
    {
        try {
            Favorite::where('image_id', $imageId)->delete();
        } catch (\Exception $e) {
            throw RepositoryException::deleteError($imageId, $e);
        }
    }

    public function getFavoritesCountForImage(int $imageId): int
    {
        return Favorite::where('image_id', $imageId)->count();
    }

    public function removeFavorite(int $userId, int $imageId): void
    {
        try {
            $favorite = Favorite::where('user_id', $userId)
                ->where('image_id', $imageId)
                ->firstOrFail();
                
            $favorite->delete();
        } catch (ModelNotFoundException $e) {
            throw RepositoryException::notFound($userId, $imageId, $e);
        } catch (\Exception $e) {
            throw RepositoryException::deleteError("user: $userId, image: $imageId", $e);
        }
    }

    public function addFavorite(int $userId, int $imageId): void
    {
        try {
            Favorite::create([
                'user_id' => $userId,
                'image_id' => $imageId
            ]);
        } catch (\Exception $e) {
            throw RepositoryException::createError("user: $userId, image: $imageId", $e);
        }
    }

    public function userHasFavorite(int $userId, int $imageId): bool
    {
        return Favorite::where('user_id', $userId)
            ->where('image_id', $imageId)
            ->exists();
    }
}
