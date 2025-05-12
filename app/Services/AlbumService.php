<?php

namespace App\Services;

use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Dto\AlbumDTO;
use App\Exceptions\AlbumNotFoundException;

class AlbumService
{
    public function __construct(
        private AlbumRepositoryInterface $albumRepository
    ) {}

    public function getUserAlbumByName(string $albumName, int $userId): Album
    {
        $album = $this->albumRepository->getUserAlbumByName($albumName, $userId);
        
        if (!$album) {
            throw new AlbumNotFoundException("Album not found");
        }
        
        return $album;
    }

    public function updateName(string $oldAlbumName, string $newAlbumName, int $userId): void
    {
        $this->albumRepository->updateName($oldAlbumName, $newAlbumName, $userId);
    }

    public function createAlbum(string $albumName, int $userId): Album
    {
        $albumDTO = new AlbumDTO($albumName, $userId);
        return $this->albumRepository->save($albumDTO);
    }
}
