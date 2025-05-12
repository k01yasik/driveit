<?php

namespace App\Http\Controllers;

use App\Dto\ImageUploadDTO;
use App\Http\Requests\{AvatarImageRequest, BodyImageUploadRequest, PostImageUploadRequest};
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;

class ImageUploadController extends Controller
{
    public function __construct(
        private ImageUploadService $imageUploadService
    ) {}

    public function uploadPostImage(PostImageUploadRequest $request): JsonResponse
    {
        $dto = ImageUploadDTO::fromPostRequest($request);
        $result = $this->imageUploadService->handlePostImageUpload($dto);
        
        return response()->json($result);
    }

    public function uploadBodyImage(BodyImageUploadRequest $request): JsonResponse
    {
        $dto = ImageUploadDTO::fromBodyRequest($request);
        $url = $this->imageUploadService->handleBodyImageUpload($dto);
        
        return response()->json(['url' => $url]);
    }

    public function uploadAvatar(AvatarImageRequest $request): JsonResponse
    {
        $dto = ImageUploadDTO::fromAvatarRequest($request);
        $avatarUrl = $this->imageUploadService->handleAvatarUpload($dto);
        
        return response()->json(['url' => $avatarUrl]);
    }

    public function uploadToAlbum(AlbumImageUploadRequest $request): JsonResponse
    {
        $dto = ImageUploadDTO::fromAlbumRequest($request);
        $result = $this->imageUploadService->handleAlbumImageUpload($dto);
        
        return response()->json($result);
    }

    public function deleteImage(DeleteImageRequest $request): JsonResponse
    {
        $this->imageUploadService->deleteImage($request->validated());
        return response()->json(['status' => 'success']);
    }
}
