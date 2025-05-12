<?php

namespace App\DTO;

use Illuminate\Http\UploadedFile;

class ImageUploadDTO
{
    public function __construct(
        public readonly UploadedFile $file,
        public readonly int $userId,
        public readonly ?string $albumName = null,
        public readonly ?array $cropData = null
    ) {}

    public static function fromPostRequest(PostImageUploadRequest $request): self
    {
        return new self(
            file: $request->file('post_upload'),
            userId: $request->user()->id
        );
    }

    public static function fromAvatarRequest(AvatarImageRequest $request): self
    {
        return new self(
            file: $request->file('avatar_upload'),
            userId: $request->user()->id,
            cropData: [
                'x' => $request->x,
                'y' => $request->y,
                'width' => $request->width,
                'height' => $request->height
            ]
        );
    }
}
