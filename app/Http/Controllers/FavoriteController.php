<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{

    /**
     * @var FavoriteService
     */
    private $favoriteService;

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

    public function unvote(FavoriteService $request)
    {
        $imageId = $request->validated()['id'];

        $userId = Auth::id();

        $this->favoriteService->removeVote($userId, $imageId);

        return $this->favoriteService->getFavCountForImage($imageId);
    }
}
