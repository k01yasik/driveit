<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Rating;

class RatingController extends Controller
{
    public function update(RatingRequest $request)
    {
        $data = $request->validated();
        $user_id = Auth::id();

        $post = Rating::where([['post_id', $data['id']], ['user_id', $user_id]])->first();

        if(!$post) {
            $rating = new Rating;
            $rating->user_id = $user_id;
            $rating->post_id = $data['id'];
            $rating->rating = 1;
            $rating->save();
        } else {
            if ($post->rating === 0) {
                $post->increment('rating');
            } else {
                $post->decrement('rating');
            }

            event('eloquent.saved: App\Rating', $post);
        }

        $i = 0;
        $newRating = Post::find($data['id'])->rating()->get();

        foreach ($newRating as $new) {
            if ($new->rating === 1) {
                $i+=1;
            }
        }

        return $i;
    }
}
