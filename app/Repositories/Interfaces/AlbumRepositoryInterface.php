<?php

namespace App\Repositories\Interfaces;

use App\Models\Album;
use App\Dto\AlbumDTO;

interface AlbumRepositoryInterface
{
    public function getUserAlbumByName(string $albumName, int $userId): ?Album;
    public function save(AlbumDTO $albumDTO): Album;
    public function updateName(string $oldAlbumName, string $newAlbumName, int $userId): void;
}
