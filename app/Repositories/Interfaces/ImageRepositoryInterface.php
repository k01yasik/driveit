<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Collection;
use App\User as User;

interface ImageRepositoryInterface
{
    public function store(string $url, string $path, string $imageName, string $pathThumbnail, string $urlThumbnail, Model $model): int;

    public function getUserImage(User $user, int $albumId, int $imageId): Model;

    public function getPostImage(User $user, string $albumName, string $imageUrl): Model;

    public function getAllAlbumImages(int $album_id): Collection;
}