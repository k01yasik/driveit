<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Image;

class UploadImageService
{
    public function storeToPublicDisk(UploadedFile $image, $type)
    {
        $username = Auth::user()->username;

        $path = $image->storePubliclyAs($username .'/'.$type, $image->getClientOriginalName(), ['disk' => 'public']);

        $imageUrl = Storage::disk('public')->url($path);

        return ['url' => $imageUrl, 'path' => $path, 'name' => $image->getClientOriginalName()];
    }

    public function saveToImageTable($image_item)
    {
        $image = new Image;
        $image->url = $image_item['url'];
        $image->path = $image_item['path'];
        $image->name = $image_item['name'];

        Auth::user()->albums()->where('name', 'posts')->first()->images()->save($image);
    }
}