<?php

namespace App\Http\Controllers;

use App\Http\Requests\BodyImageUpload;
use App\Http\Requests\PostImageUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function index(PostImageUpload $request) {

        $data = $request->validated()['post_upload'];

        $path = $data->storePubliclyAs('images', $data->getClientOriginalName(), ['disk' => 'public']);

        return Storage::disk('public')->url($path);

    }

    public function upload(BodyImageUpload $request) {

        $data = $request->validated()['body_post_upload'];

        $path = $data->storePubliclyAs('images/post', $data->getClientOriginalName(), ['disk' => 'public']);

        return Storage::disk('public')->url($path);

    }

    public function destroy(Request $request) {

        $url = $request->query('url');

        $urlArray = explode('/', $url);

        $urlArrayLength = count($urlArray);

        $path = implode('/', [$urlArray[$urlArrayLength - 2], $urlArray[$urlArrayLength - 1]]);

        Storage::disk('public')->delete($path);

        return 'ok';
    }
}
