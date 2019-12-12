<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Services\RatingService;

class RatingController extends Controller
{
    protected $ratingRepository;
    protected $ratingService;

    public function __construct(RatingRepositoryInterface $ratingRepository, RatingService $ratingService)
    {
        $this->ratingRepository = $ratingRepository;
        $this->ratingService = $ratingService;
    }

    public function update(RatingRequest $request)
    {
        $data = $request->validated();
        $user_id = Auth::id();

        $post = $this->ratingRepository->getUserRatingForPost($data['id'], $user_id);

        if(!$post) {
            $this->ratingRepository->store($data['id'], $user_id);
        } else {

            $this->ratingService->toggleRating($post);

            event('eloquent.saved: App\Rating', $post);
        }

        $i = $this->ratingService->calculatePostRating($data['id']);

        return $i;
    }
}
