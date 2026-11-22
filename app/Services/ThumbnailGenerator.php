<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

class ThumbnailGenerator
{
    public function generate(UploadedFile $file, ?array $cropData = null): string
    {
        $image = ImageManager::gd()->read($file);
        
        if ($cropData) {
            $image->crop(
                $cropData['width'],
                $cropData['height'],
                $cropData['x'],
                $cropData['y']
            );
        }
        
        return (string) $image->toJpeg(80);
    }
}
