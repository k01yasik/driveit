<?php

namespace App\Services;

use App\Services\Interfaces\ImageProcessorInterface;
use GuzzleHttp\Psr7\Utils;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Psr\Http\Message\StreamInterface;

class ImageProcessor implements ImageProcessorInterface
{
    public function crop(mixed $imageSource, int $width, int $height, int $x, int $y): Image
    {
        return ImageManager::gd()->read($imageSource)->crop($width, $height, $x, $y);
    }

    public function fit(mixed $imageSource, int $width, int $height): Image
    {
        return ImageManager::gd()->read($imageSource)->cover($width, $height);
    }

    public function createStream(Image $image): StreamInterface
    {
        return Utils::streamFor((string) $image->toJpeg());
    }
}
