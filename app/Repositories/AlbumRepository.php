<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Album;
use App\Dto\AlbumDTO;
use Illuminate\Support\Str;

class AlbumRepository implements AlbumRepositoryInterface
{
    public function getUserAlbumByName(string $albumName, int $userId): ?Album
    {
        return Album::where([
            ['user_id', $userId],
            ['name', $albumName]
        ])->first();
    }

    public function save(AlbumDTO $albumDTO): Album
    {
        return Album::create([
            'name' => $albumDTO->name,
            'path' => Str::random(10),
            'user_id' => $albumDTO->userId
        ]);
    }

    public function updateName(string $oldAlbumName, string $newAlbumName, int $userId): void
    {
        Album::where([
            ['name', $oldAlbumName],
            ['user_id', $userId]
        ])->update(['name' => $newAlbumName]);
    }
}
