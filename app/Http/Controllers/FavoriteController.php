<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Services\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\FavoriteException;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends Controller
{
    private FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * Add favorite for image
     *
     * @param FavoriteRequest $request
     * @return JsonResponse
     */
    public function addFavorite(FavoriteRequest $request): JsonResponse
    {
        try {
            $imageId = $request->validated()['id'];
            $userId = Auth::id();

            $this->favoriteService->addFavorite($userId, $imageId);

            return response()->json([
                'success' => true,
                'count' => $this->favoriteService->getFavoritesCountForImage($imageId)
            ], Response::HTTP_CREATED);

        } catch (FavoriteException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Remove favorite for image
     *
     * @param FavoriteRequest $request
     * @return JsonResponse
     */
    public function removeFavorite(FavoriteRequest $request): JsonResponse
    {
        try {
            $imageId = $request->validated()['id'];
            $userId = Auth::id();

            $this->favoriteService->removeFavorite($userId, $imageId);

            return response()->json([
                'success' => true,
                'count' => $this->favoriteService->getFavoritesCountForImage($imageId)
            ]);

        } catch (FavoriteException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Get favorites count for image
     *
     * @param int $imageId
     * @return JsonResponse
     */
    public function getFavoritesCount(int $imageId): JsonResponse
    {
        return response()->json([
            'count' => $this->favoriteService->getFavoritesCountForImage($imageId)
        ]);
    }
}
