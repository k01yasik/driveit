<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Requests\BodyImageUpload;
use App\Http\Requests\PostImageUpload;
use App\Services\UploadImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Thumb;
use App\Album;
use App\Image;


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

    public function avatar(Request $request) {

        $data = $request->validate([
            'avatar_upload' => 'required|image',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'height' => 'required|integer',
            'width' => 'required|integer'
        ]);

        $image = $data['avatar_upload'];
        $user = Auth::user();
        $username = $user->username;
        $image_name = $image->getClientOriginalName();

        $avatar = Thumb::make($image)->crop($data['width'], $data['height'], $data['x'], $data['y']);
        $stream = $avatar->stream('jpg', 80);

        Storage::disk('public')->put($username.'/avatars/'.$image_name, $stream);

        $avatar_path = $username.'/avatars/'.$image_name;
        $avatar_url =  Storage::disk('public')->url($avatar_path);

        $profile = $user->profile()->firstOrFail();
        $profile->avatar = $avatar_url;
        $profile->save();

        event('eloquent.saved: App\Profile', $profile);

        return $avatar_url;
    }

    public function image(Request $request) {

        $username = Auth::user()->username;

        $images = $request->images_upload;
        $album_name = $request->album_name;

        $album = Album::where([['user_id', Auth::id()], ['name', $album_name]])->firstOrFail();

        $result = [];

        foreach ($images as $image) {
            $image_name = $image->getClientOriginalName();

            $path = $image->storePubliclyAs($username.'/'.$album->path, $image_name, ['disk' => 'public']);
            $url = Storage::disk('public')->url($path);

            $thumbnail = Thumb::make($image)->fit(270, 360);

            $stream = $thumbnail->stream('jpg', 80);
            Storage::disk('public')->put($username.'/'.$album->path.'/thumbnail/'.$image_name, $stream);

            $path_thumbnail = $username.'/'.$album->path.'/thumbnail/'.$image_name;
            $url_thumbnail = Storage::disk('public')->url($path_thumbnail);

            $image_table = new Image;
            $image_table->url = $url;
            $image_table->path = $path;
            $image_table->name = $image_name;
            $image_table->path_thumbnail = $path_thumbnail;
            $image_table->url_thumbnail = $url_thumbnail;
            $image_table->album()->associate($album);
            $image_table->save();

            array_push($result, [$image_name, $url_thumbnail, $image_table->id, $username, $album->id]);
        }

        return $result;
    }

    public function delete(Request $request) {

        $user = Auth::user();
        $id = $request->query('id');
        $album_id = $request->query('album');

        $image = $user->albums()->where('id', $album_id)->firstOrFail()->images()->where('id', $id)->firstOrFail();

        Storage::disk('public')->delete($image->path);

        if ($image->path_thumbnail) {
            Storage::disk('public')->delete($image->path_thumbnail);
        }

        $image->delete();

        Favorite::where('image_id', $id)->delete();

        return 'ok';
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
