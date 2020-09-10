<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Services\FavoriteService;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{

    /**
     * @var FavoriteService
     */
    private FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function vote(FavoriteRequest $request)
    {
        $imageId = $request->validated()['id'];

        $userId = Auth::id();

        $this->favoriteService->vote($userId, $imageId);

        return $this->favoriteService->getFavCountForImage($imageId);
    }

    public function unvote(FavoriteRequest $request)
    {
        $imageId = $request->validated()['id'];

        $userId = Auth::id();

        $this->favoriteService->removeVote($userId, $imageId);

        return $this->favoriteService->getFavCountForImage($imageId);
    }
}
