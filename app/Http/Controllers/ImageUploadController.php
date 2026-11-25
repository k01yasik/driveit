<?php

namespace App\Http\Controllers;

use App\Dto\ImageUploadDTO;
use App\Http\Requests\{AvatarImageRequest, BodyImageUpload, PostImageUploadRequest};
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function uploadBodyImage(BodyImageUpload $request): JsonResponse
    {
        $url = $this->imageUploadService->handleBodyImageUpload(
            $request->user()->id,
            $request->validated('type'),
            $request->file('upload_image_form_input')
        );

        return response()->json(['url' => $url]);
    }

    public function uploadAvatar(AvatarImageRequest $request): JsonResponse
    {
        $dto = ImageUploadDTO::fromAvatarRequest($request);
        $avatarUrl = $this->imageUploadService->handleAvatarUpload($dto);
        
        return response()->json(['url' => $avatarUrl]);
    }

    public function uploadToAlbum(Request $request): JsonResponse
    {
        $data = $request->validate([
            'album_name' => 'required|string',
            'images_upload' => 'required|array|min:1',
            'images_upload.*' => 'required|image|mimes:jpeg,png|max:5000',
        ]);
        $this->imageUploadService->handleAlbumImageUpload(
            $request->user()->id,
            $data['album_name'],
            $data['images_upload']
        );

        return response()->json(['status' => 'success'], 201);
    }

    public function deleteImage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'album' => 'required|integer',
            'id' => 'required|integer',
        ]);
        $this->imageUploadService->deleteImage($request->user()->id, $data['album'], $data['id']);

        return response()->json(['status' => 'success']);
    }
}
