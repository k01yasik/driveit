<?php

namespace App\Repositories;

use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Favorite;

class FavoriteRepository implements FavoriteRepositoryInterface
{

    public function vote(int $imageId): int
    {
        $userId = Auth::id();

        $favorite = Favorite::where([['user_id', $userId], ['image_id', $imageId]])->first();


        if ($favorite) {
            try {
                $favorite->delete();
            } catch (\Exception $e) {

            }
        } else {
            $favorite_new = new Favorite;
            $favorite_new->user_id = $userId;
            $favorite_new->image_id = $imageId;
            $favorite_new->save();
        }

        return Favorite::where('image_id', $imageId)->get()->count();
    }

    public function delete(int $imageId): void
    {
        Favorite::where('image_id', $imageId)->delete();
    }
}