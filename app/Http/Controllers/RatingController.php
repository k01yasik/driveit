<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Services\RatingService;

class RatingController extends Controller
{
    public function __construct(private RatingService $ratingService)
    {
    }

    public function update(RatingRequest $request): int
    {
        return $this->ratingService->toggleRating($request->validated('id'), $request->user()->id);
    }
}
