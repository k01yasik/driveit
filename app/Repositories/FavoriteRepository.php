<?php

namespace App\Repositories;

use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Favorite;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    public function delete(int $imageId): void
    {
        try {
            Favorite::where('image_id', $imageId)->delete();
        } catch (\Exception $e) {
        }
    }

    public function getFavCountForImage(int $imageId): int
    {
        return Favorite::where('image_id', $imageId)->count();
    }

    public function removeVote(int $userId, int $imageId): void
    {
        try {
            Favorite::where([['user_id', $userId], ['image_id', $imageId]])->first()->delete();
        } catch (\Exception $e) {
        }
    }

    public function add(int $userId, int $imageId): void
    {
        $favorite = new Favorite;
        $favorite->user_id = $userId;
        $favorite->image_id = $imageId;
        $favorite->save();
    }
}