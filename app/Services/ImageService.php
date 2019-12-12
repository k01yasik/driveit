<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Image as Image;
use Intervention\Image\Facades\Image as Thumb;
use Psr\Http\Message\StreamInterface;
use Illuminate\Database\Eloquent\Model as Model;

class ImageService
{
    public function createThumbnail(mixed $image, int $width, int $height, int $x, int $y): Image
    {
        return Thumb::make($image)->crop($width, $height, $x, $y);
    }

    public function createStream(Image $image): StreamInterface
    {
        return $image->stream('jpg', 80);
    }

    public function storePubliclyImage(UploadedFile $image, Model $model, string $username, string $imageName): string
    {
        return $image->storePubliclyAs($username.'/'.$model->path, $imageName, ['disk' => 'public']);
    }

    public function createImageThumbnail(UploadedFile $image, int $width, int $height): Image
    {
        return Thumb::make($image)->fit($width, $height);
    }
}