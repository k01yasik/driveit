<?php

namespace App\Services\Interfaces;

use Intervention\Image\Image as InterventionImage;
use Psr\Http\Message\StreamInterface;

interface ImageProcessorInterface
{
    public function crop(mixed $imageSource, int $width, int $height, int $x, int $y): InterventionImage;
    public function fit(mixed $imageSource, int $width, int $height): InterventionImage;
    public function createStream(InterventionImage $image): StreamInterface;
}
