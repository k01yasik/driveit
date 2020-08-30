<?php

namespace App\Repositories\Interfaces;

interface ImageRepositoryInterface
{
    public function add(string $url, string $path, string $imageName, string $pathThumbnail, string $urlThumbnail, int $albumId): void;

    public function getByPath(string $path): array;

    public function deleteImage(int $userId, int $albumId, int $imageId): void;

    public function deletePostImageByUrl(int $userId, string $albumName, string $url): void;

    public function getAllAlbumImages(int $album_id): array;
}