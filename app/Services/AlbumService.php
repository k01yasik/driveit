<?php

namespace App\Services;


use App\Repositories\Interfaces\AlbumRepositoryInterface;

class AlbumService
{
    protected AlbumRepositoryInterface $albumRepository;

    public function __construct(AlbumRepositoryInterface $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    public function getUserAlbumByName(string $albumName, int $userId): array
    {
        return $this->albumRepository->getUserAlbumByName($albumName, $userId);
    }

    public function updateName(string $oldAlbumName, string $newAlbumName, int $userId): void
    {
        $this->albumRepository->updateName($oldAlbumName, $newAlbumName, $userId);
    }

    public function save(string $cleanAlbumName, int $userId)
    {
        $this->albumRepository->save($cleanAlbumName, $userId);
    }
}