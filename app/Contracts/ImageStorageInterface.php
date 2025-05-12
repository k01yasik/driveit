<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface ImageStorageInterface
{
    public function store(UploadedFile $file, string $directory): string;
    public function storeAvatar($imageData, int $userId): string;
    public function getUrl(string $path): string;
    public function delete(string $path): bool;
}
