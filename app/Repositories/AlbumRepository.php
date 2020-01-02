<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AlbumRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Album;
use Illuminate\Support\Str;

class AlbumRepository implements AlbumRepositoryInterface
{

    public function getUserAlbumByName(string $albumName): Model
    {
        return Album::where([['user_id', Auth::id()], ['name', $albumName]])->firstOrFail();
    }

    public function store($album_name): void
    {
        $album = new Album;
        $album->name = $album_name;
        $album->path = Str::random(10);
        $album->user_id = Auth::id();
        $album->save();
    }
}