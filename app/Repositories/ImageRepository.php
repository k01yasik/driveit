<?php

namespace App\Repositories;

use App\Album;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use App\Image;

class ImageRepository implements ImageRepositoryInterface
{

    /**
     * @param string $url
     * @param string $path
     * @param string $imageName
     * @param string $pathThumbnail
     * @param string $urlThumbnail
     * @param int $albumId
     * @return void
     */
    public function add(string $url, string $path, string $imageName, string $pathThumbnail, string $urlThumbnail, int $albumId): void
    {
        $imageTable = new Image;
        $imageTable->url = $url;
        $imageTable->path = $path;
        $imageTable->name = $imageName;
        $imageTable->path_thumbnail = $pathThumbnail;
        $imageTable->url_thumbnail = $urlThumbnail;
        $imageTable->album_id = $albumId;
        $imageTable->save();
    }

    public function getByPath(string $path): array
    {
        return Image::where('path', $path)->first()->toArray();
    }

    /**
     * @param int $userId
     * @param int $albumId
     * @param int $imageId
     * @throws Exception
     */
    public function deleteImage(int $userId, int $albumId, int $imageId): void
    {
        Album::where([['id', $albumId], ['user_id', $userId]])->images()->where('id', $imageId)->first()->delete();
    }

    /**
     * @param int $userId
     * @param string $albumName
     * @param string $url
     * @throws Exception
     */
    public function deletePostImageByUrl(int $userId, string $albumName, string $url): void
    {
        Album::where([['user_id', $userId], ['name', $albumName]])->images()->where('url', $url)->first()->delete();
    }

    public function getAllAlbumImages(int $albumId): array
    {
        return Image::with('favorites')->where('album_id', $albumId)->orderByDesc('created_at')->get()->toArray();
    }
}