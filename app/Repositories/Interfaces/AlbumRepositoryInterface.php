<?php

namespace App\Repositories\Interfaces;

interface AlbumRepositoryInterface
{
    public function getUserAlbumByName(string $albumName, int $id): array;

    public function save($album_name, int $id): void;
}