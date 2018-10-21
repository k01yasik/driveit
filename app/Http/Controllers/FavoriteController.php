<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use Illuminate\Support\Facades\Auth;
use App\Favorite;

class FavoriteController extends Controller
{
    public function vote(FavoriteRequest $request) {
        $data = $request->validated();

        $id = $data['id'];
        $username = $data['username'];

        $user_id = Auth::id();

        $favorite = Favorite::where([['user_id', $user_id], ['image_id', $id]])->first();


        if ($favorite) {
            $favorite->delete();
        } else {
            $favorite_new = new Favorite;
            $favorite_new->user_id = $user_id;
            $favorite_new->image_id = $id;
            $favorite_new->save();
        }

        return Favorite::where('image_id', $id)->get()->count();
    }
}
