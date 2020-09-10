<?php

namespace App\Repositories\Interfaces;

interface AlbumRepositoryInterface
{
    public function getUserAlbumByName(string $albumName, int $id): array;

    public function save(string $albumName, int $userId): void;

    public function updateName(string $oldAlbumName, string $newAlbumName, int $userId): void;
}