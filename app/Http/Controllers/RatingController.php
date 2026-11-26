<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Services\RatingService;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    public function __construct(private RatingService $ratingService)
    {
    }

    public function update(RatingRequest $request): Response
    {
        $result = $this->ratingService->toggleWithStatus($request->validated('id'), $request->user()->id);

        return response((string) $result['count'])->header('X-Rating-Voted', $result['voted'] ? '1' : '0');
    }
}
