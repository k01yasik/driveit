<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AlbumRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Album;

class AlbumRepository implements AlbumRepositoryInterface
{

    public function getUserAlbumByName(string $albumName): Model
    {
        return Album::where([['user_id', Auth::id()], ['name', $albumName]])->firstOrFail();
    }
}