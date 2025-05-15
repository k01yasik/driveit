<?php

namespace App\Services;

use App\Repositories\Interfaces\ImageRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image as InterventionImage;
use Intervention\Image\Facades\Image as ImageFacade;
use Psr\Http\Message\StreamInterface;

class ImageService
{
    public function __construct(
        private ImageRepositoryInterface $imageRepository,
        private ImageProcessorInterface $imageProcessor
    ) {
    }

    public function createThumbnail(
        mixed $imageSource, 
        int $width, 
        int $height, 
        int $x = 0, 
        int $y = 0
    ): InterventionImage {
        return $this->imageProcessor->crop($imageSource, $width, $height, $x, $y);
    }

    public function createStream(InterventionImage $image): StreamInterface
    {
        return $this->imageProcessor->createStream($image);
    }

    public function storePubliclyImage(
        UploadedFile $image,
        string $storagePath,
        string $imageName
    ): string {
        return $image->storePubliclyAs(
            $storagePath,
            $imageName,
            ['disk' => 'public']
        );
    }

    public function createImageThumbnail(
        UploadedFile $image, 
        int $width, 
        int $height
    ): InterventionImage {
        return $this->imageProcessor->fit($image, $width, $height);
    }

    public function addImage(ImageData $imageData): int
    {
        $image = $this->imageRepository->create($imageData->toArray());
        
        return $image->id;
    }

    public function deleteImage(int $userId, int $albumId, int $imageId): void
    {
        $this->imageRepository->deleteByUserAndAlbum($userId, $albumId, $imageId);
    }

    public function deletePostImageByUrl(
        int $userId, 
        string $albumName, 
        string $url
    ): void {
        $this->imageRepository->deleteByUserAlbumNameAndUrl($userId, $albumName, $url);
    }

    public function getAlbumImages(int $albumId): array
    {
        return $this->imageRepository->getAllByAlbumId($albumId);
    }
}
