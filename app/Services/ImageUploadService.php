<?php

namespace App\Services;

use App\Dto\ImageUploadDTO;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Contracts\ImageStorageInterface;
use App\Album;
use App\Exceptions\AlbumNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImageUploadService
{
    public function __construct(
        private AlbumRepositoryInterface $albumRepository,
        private ImageStorageInterface $storage,
        private ThumbnailGenerator $thumbnailGenerator,
        private ProfileService $profileService
    ) {}

    public function handlePostImageUpload(ImageUploadDTO $dto): array
    {
        $path = $this->storage->store($dto->file, 'posts');
        return ['url' => $this->storage->getUrl($path), 'path' => $path];
    }

    public function handleBodyImageUpload(int $userId, string $type, UploadedFile $file): string
    {
        $album = Album::firstOrCreate(
            ['user_id' => $userId, 'name' => 'posts'],
            ['path' => Str::random(10)]
        );
        $path = $this->storage->store($file, "albums/{$album->path}/{$type}");

        try {
            $url = $this->storage->getUrl($path);
            $album->images()->create(['url' => $url, 'path' => $path, 'name' => $file->getClientOriginalName()]);

            return $url;
        } catch (Throwable $exception) {
            $this->storage->delete($path);

            throw $exception;
        }
    }

    public function handleAvatarUpload(ImageUploadDTO $dto): string
    {
        $thumbnail = $this->thumbnailGenerator->generate($dto->file, $dto->cropData);
        $path = $this->storage->storeAvatar($thumbnail, $dto->userId);
        
        $url = $this->storage->getUrl($path).'?v='.hash('sha256', $thumbnail);
        $this->profileService->addUserAvatar($dto->userId, $url);

        return $url;
    }

    public function handleAlbumImageUpload(int $userId, string $albumName, array $files): void
    {
        $album = $this->albumRepository->getUserAlbumByName($albumName, $userId)
            ?? throw new AlbumNotFoundException('Album not found');
        $storedPaths = [];

        try {
            DB::transaction(function () use ($album, $files, &$storedPaths) {
                foreach ($files as $file) {
                    $path = $this->storage->store($file, "albums/{$album->path}");
                    $storedPaths[] = $path;
                    $album->images()->create([
                        'url' => $this->storage->getUrl($path),
                        'path' => $path,
                        'name' => $file->getClientOriginalName(),
                    ]);
                }
            });
        } catch (Throwable $exception) {
            foreach ($storedPaths as $path) {
                $this->storage->delete($path);
            }

            throw $exception;
        }
    }

    public function deleteImage(int $userId, int $albumId, int $imageId): void
    {
        DB::transaction(function () use ($userId, $albumId, $imageId) {
            $image = Album::where('user_id', $userId)->findOrFail($albumId)
                ->images()->lockForUpdate()->findOrFail($imageId);
            $image->favorites()->delete();
            $image->delete();

            DB::afterCommit(function () use ($image) {
                $this->storage->delete($image->path);
                if ($image->path_thumbnail) {
                    $this->storage->delete($image->path_thumbnail);
                }
            });
        }, 3);
    }
}
