<?php

namespace App\Services\Storage;

use App\Contracts\ImageStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalImageStorage implements ImageStorageInterface
{
    public function store(UploadedFile $file, string $directory): string
    {
        return Storage::disk('public')->putFile($directory, $file);
    }

    public function storeAvatar($imageData, int $userId): string
    {
        $path = 'avatars/'.$userId.'.jpg';
        if (!Storage::disk('public')->put($path, $imageData)) {
            throw new \RuntimeException('Could not store the avatar.');
        }

        return $path;
    }

    public function delete(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    public function getUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }
}
