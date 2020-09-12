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

    public function save(string $albumName, int $userId): void
    {
        $album = new Album;
        $album->name = $albumName;
        $album->path = Str::random(10);
        $album->user_id = $userId;
        $album->save();
    }

    public function updateName(string $oldAlbumName, string $newAlbumName, int $userId): void
    {
        Album::where([['name', $oldAlbumName], ['user_id', $userId]])->update(['name' => $newAlbumName]);
    }
}