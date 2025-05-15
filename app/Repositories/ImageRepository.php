<?php

namespace App\Repositories;

use App\Album;
use App\Image;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\Exceptions\ImageNotFoundException;

class ImageRepository implements ImageRepositoryInterface
{
    public function create(array $imageData): Image
    {
        return Image::create($imageData);
    }

    public function getByPath(string $path): Image
    {
        $image = Image::where('path', $path)->first();
        
        if (!$image) {
            throw new ImageNotFoundException("Image with path {$path} not found");
        }
        
        return $image;
    }

    public function deleteByUserAndAlbum(int $userId, int $albumId, int $imageId): void
    {
        $image = Album::where('user_id', $userId)
            ->where('id', $albumId)
            ->firstOrFail()
            ->images()
            ->where('id', $imageId)
            ->firstOrFail();
            
        $image->delete();
    }

    public function deleteByUserAlbumNameAndUrl(int $userId, string $albumName, string $url): void
    {
        $image = Album::where('user_id', $userId)
            ->where('name', $albumName)
            ->firstOrFail()
            ->images()
            ->where('url', $url)
            ->firstOrFail();
            
        $image->delete();
    }

    public function getAllByAlbumId(int $albumId): array
    {
        return Image::with('favorites')
            ->where('album_id', $albumId)
            ->latest()
            ->get()
            ->toArray();
    }
}
