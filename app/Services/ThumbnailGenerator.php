<?php

namespace App\Services;

use Intervention\Image\ImageManager;

class ThumbnailGenerator
{
    public function __construct(
        private ImageManager $imageManager
    ) {}

    public function generate(UploadedFile $file, array $cropData = null): string
    {
        $image = $this->imageManager->make($file);
        
        if ($cropData) {
            $image->crop(
                $cropData['width'],
                $cropData['height'],
                $cropData['x'],
                $cropData['y']
            );
        }
        
        return $image->encode('jpg', 80)->stream();
    }
}
