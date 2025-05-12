<?php

namespace App\Services;

use App\Dto\ImageUploadDTO;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Services\Thumbnail\{ThumbnailGenerator, ThumbnailStrategy};
use App\Contracts\ImageStorageInterface;
use App\Image;

class ImageUploadService
{
    public function __construct(
        private AlbumRepositoryInterface $albumRepository,
        private ImageStorageInterface $storage,
        private ThumbnailGenerator $thumbnailGenerator
    ) {}

    public function handlePostImageUpload(ImageUploadDTO $dto): array
    {
        $path = $this->storage->store($dto->file, 'posts');
        $url = $this->storage->getUrl($path);
        
        $image = Image::create([
            'url' => $url,
            'path' => $path,
            'user_id' => $dto->userId,
            'type' => 'post'
        ]);
        
        return $image->toArray();
    }

    public function handleAvatarUpload(ImageUploadDTO $dto): string
    {
        $thumbnail = $this->thumbnailGenerator->generate($dto->file, $dto->cropData);
        $path = $this->storage->storeAvatar($thumbnail, $dto->userId);
        
        return $this->storage->getUrl($path);
    }

    public function handleAlbumImageUpload(ImageUploadDTO $dto): array
    {
        $album = $this->albumRepository->getUserAlbumByName($dto->albumName, $dto->userId);
        
        $path = $this->storage->store($dto->file, "albums/{$album->path}");
        $thumbnailPath = $this->thumbnailGenerator->generateForAlbum($dto->file);
        
        $image = Image::create([
            'url' => $this->storage->getUrl($path),
            'path' => $path,
            'thumbnail_path' => $thumbnailPath,
            'album_id' => $album->id,
            'user_id' => $dto->userId
        ]);
        
        return $image->toArray();
    }

    public function deleteImage(array $data): void
    {
        // Логика удаления изображения
    }
}
