<?php

namespace App\Repositories\Interfaces;

use App\Image;

interface ImageRepositoryInterface
{
    public function create(array $imageData): Image;
    public function getByPath(string $path): Image;
    public function deleteByUserAndAlbum(int $userId, int $albumId, int $imageId): void;
    public function deleteByUserAlbumNameAndUrl(int $userId, string $albumName, string $url): void;
    public function getAllByAlbumId(int $albumId): array;
}
