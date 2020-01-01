<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Image;

class ImageRepository implements ImageRepositoryInterface
{

    /**
     * @param string $url
     * @param string $path
     * @param string $imageName
     * @param string $pathThumbnail
     * @param string $urlThumbnail
     * @param Model $model
     * @return int
     */
    public function store(string $url, string $path, string $imageName, string $pathThumbnail, string $urlThumbnail, Model $model): int
    {
        $imageTable = new Image;
        $imageTable->url = $url;
        $imageTable->path = $path;
        $imageTable->name = $imageName;
        $imageTable->path_thumbnail = $pathThumbnail;
        $imageTable->url_thumbnail = $urlThumbnail;
        $imageTable->album()->associate($model);
        $imageTable->save();

        return $imageTable->id;
    }

    /**
     * @param User $user
     * @param int $albumId
     * @param int $imageId
     * @return Model
     */
    public function getUserImage(User $user, int $albumId, int $imageId): Model
    {
        return $user->albums()->where('id', $albumId)->firstOrFail()->images()->where('id', $imageId)->firstOrFail();
    }

    /**
     * @param User $user
     * @param string $albumName
     * @param string $imageUrl
     * @return Model
     */
    public function getPostImage(User $user, string $albumName, string $imageUrl): Model
    {
        return $user->albums()->where('name', $albumName)->firstOrFail()->images()->where('url', $imageUrl)->firstOrFail();
    }

    public function getAllAlbumImages(int $album_id): Collection
    {
        return Image::with('favorites')->where('album_id', $album_id)->orderByDesc('created_at')->get();
    }
}