<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Favorite;

class FavoriteController extends Controller
{
    protected $favoriteRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function vote(FavoriteRequest $request) {
        $data = $request->validated();

        $imageId = $data['id'];

        return $this->favoriteRepository->vote($imageId);
    }
}
