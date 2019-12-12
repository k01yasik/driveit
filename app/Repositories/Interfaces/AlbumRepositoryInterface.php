<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model as Model;

interface AlbumRepositoryInterface
{
    public function getUserAlbumByName(string $albumName): Model;
}