<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\StreamInterface;

class StorageService
{
    /**
     * @param string $username
     * @param string $imageName
     * @param StreamInterface $stream
     */
    public function storeImage(string $username, string $imageName, StreamInterface $stream): void
    {
        Storage::disk('public')->put($username.'/avatars/'.$imageName, $stream);
    }

    public function storeThumbnailImage(string $username,
                                        string $albumPath,
                                        string $imageName,
                                        StreamInterface $stream): void
    {
        Storage::disk('public')->put($username.'/'.$albumPath.'/thumbnail/'.$imageName, $stream);
    }

    /**
     * @param string $path
     * @return string
     */
    public function getImageUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    public function deleteImage(string $path): void {
        Storage::disk('public')->delete($path);
    }
}