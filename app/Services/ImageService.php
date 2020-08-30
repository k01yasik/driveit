<?php

namespace App\Services;

use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\User;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image as Image;
use Intervention\Image\Facades\Image as Thumb;
use Psr\Http\Message\StreamInterface;
use Illuminate\Database\Eloquent\Model as Model;

class ImageService
{
    protected $imageRepository;

    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

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

    public function add(string $url, string $path, string $imageName, string $pathThumbnail, string $urlThumbnail, int $albumId): int
    {
        $this->imageRepository->add($url, $path, $imageName, $pathThumbnail, $urlThumbnail, $albumId);

        $image = $this->imageRepository->getByPath($path);

        return $image['id'];
    }

    public function deleteImage(int $userId, int $albumId, int $imageId): void
    {
        $this->imageRepository->deleteImage($userId, $albumId, $imageId);
    }

    public function deletePostImageByUrl(int $userId, string $albumName, string $url): void
    {
        $this->imageRepository->deletePostImageByUrl($userId, $albumName, $url);
    }

    public function getAllAlbumImages(int $albumId): array
    {
        return $this->imageRepository->getAllAlbumImages($albumId);
    }
}