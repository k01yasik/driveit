<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Album;
use Illuminate\Support\Str;

class AlbumRepository implements AlbumRepositoryInterface
{

    public function getUserAlbumByName(string $albumName, int $id): array
    {
        return Album::where([['user_id', $id], ['name', $albumName]])->first()->toArray();
    }

    public function save($album_name, int $id): void
    {
        $album = new Album;
        $album->name = $album_name;
        $album->path = Str::random(10);
        $album->user_id = $id;
        $album->save();
    }
}