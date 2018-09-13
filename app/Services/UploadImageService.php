<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Image;

class UploadImageService
{
    public function storeToCloud($data)
    {
        $username = Auth::user()->username;


        $path = $data->storePubliclyAs($username .'/posts', $data->getClientOriginalName(), ['disk' => 'public']);

        $imageUrl = Storage::disk('public')->url($path);

        return ['url' => $imageUrl, 'path' => $path];
    }

    public function saveToImageTable($image_item)
    {
        $image = new Image;
        $image->url = $image_item['url'];
        $image->path = $image_item['path'];

        Auth::user()->albums()->where('name', 'posts')->first()->images()->save($image);
    }
}