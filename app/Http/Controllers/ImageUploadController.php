<?php

namespace App\Http\Controllers;

use App\Http\Requests\BodyImageUpload;
use App\Http\Requests\PostImageUpload;
use App\Services\UploadImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ImageUploadController extends Controller
{
    protected $uploadImageService;

    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }

    public function index(PostImageUpload $request) {


        $data = $request->validated()['post_upload'];

        $image_item =  $this->uploadImageService->storeToPublicDisk($data, 'post');

        $this->uploadImageService->saveToImageTable($image_item);

        return $image_item['url'];

    }

    public function upload(BodyImageUpload $request) {

        $data = $request->validated();

        $image = $data['upload_image_form_input'];
        $type = $data['type'];

        $image_item =  $this->uploadImageService->storeToPublicDisk($image, $type);

        $this->uploadImageService->saveToImageTable($image_item);

        return $image_item['url'];

    }

    public function destroy(Request $request) {

        $url = $request->query('url');

        $image = Auth::user()->albums()->where('name', 'posts')->first()->images()->where('url', $url)->first();

        if ($image) {
            Storage::disk('public')->delete($image->path);
        }

        return 'ok';
    }
}
