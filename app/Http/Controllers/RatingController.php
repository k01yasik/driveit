<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\RatingService;

class RatingController extends Controller
{
    protected RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function update(RatingRequest $request)
    {
        $postId = $request->validated()['id'];
        $userId = Auth::id();

        $post = $this->ratingService->getPostRatingByUser($postId, $userId);

        if(!$post) {
            $this->ratingService->store($postId, $userId);
        } else {
            $this->ratingService->toggleRating($post);
        }

        return $this->ratingService->calculatePostRating($postId);
    }
}
