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

    public function getUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }
}
