<?php

namespace App\Http\Controllers;

use App\Http\Requests\BodyImageUpload;
use App\Http\Requests\PostImageUpload;
use App\Services\AlbumService;
use App\Services\FavoriteService;
use App\Services\ImageService;
use App\Services\ProfileService;
use App\Services\StorageService;
use App\Services\UploadImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AvatarImage;
use Illuminate\Http\UploadedFile;
use App\Services\PathService;

class ImageUploadController extends Controller
{
    protected UploadImageService $uploadImageService;
    protected ImageService $imageService;
    protected StorageService $storageService;
    protected ProfileService $profileService;
    protected AlbumService $albumService;
    protected PathService $pathService;
    protected FavoriteService $favoriteService;

    public function __construct(UploadImageService $uploadImageService,
                                ImageService $imageService,
                                StorageService $storageService,
                                ProfileService $profileService,
                                AlbumService $albumService,
                                PathService $pathService,
                                FavoriteService $favoriteService)
    {
        $this->uploadImageService = $uploadImageService;
        $this->imageService = $imageService;
        $this->storageService = $storageService;
        $this->profileService = $profileService;
        $this->albumService = $albumService;
        $this->pathService = $pathService;
        $this->favoriteService = $favoriteService;
    }

    public function index(PostImageUpload $request) {


        $data = $request->validated()['post_upload'];

        $image_item =  $this->uploadImageService->storeToPublicDisk($data, 'post');

        $this->uploadImageService->saveToImageTable($image_item);

        return [
            'url' => $image_item['url'],
            'path' => $image_item['path']
        ];
    }

    public function upload(BodyImageUpload $request) {

        $data = $request->validated();

        $image = $data['upload_image_form_input'];
        $type = $data['type'];

        $image_item =  $this->uploadImageService->storeToPublicDisk($image, $type);

        $this->uploadImageService->saveToImageTable($image_item);

        return $image_item['url'];

    }

    /**
     * @param AvatarImage $request
     * @property UploadedFile $image
     * @return string
     */
    public function avatar(AvatarImage $request) {

        $data = $request->validated();

        $image = $data['avatar_upload'];

        $user = Auth::user();
        $userId = $user->id;
        $username = $user->username;
        $imageName = $image->getClientOriginalName();
        $avatar = $this->imageService->createThumbnail($image, $data['width'], $data['height'], $data['x'], $data['y']);

        $stream = $this->imageService->createStream($avatar);

        $this->storageService->storeImage($username, $imageName, $stream);

        $avatarPath = $this->pathService->createAvatarPath($username, $imageName);
        $avatarUrl =  $this->storageService->getImageUrl($avatarPath);

        $this->profileService->addUserAvatar($userId, $avatarUrl);

        return $avatarUrl;
    }

    public function image(Request $request) {

        $username = Auth::user()->username;

        $images = $request->images_upload;
        $albumName = $request->album_name;

        $album = $this->albumService->getUserAlbumByName($albumName, Auth::id());
        $albumPath = $album['path'];
        $albumId = $album['id'];
        $result = [];

        foreach ($images as $image) {
            $imageName = $image->getClientOriginalName();

            $path = $this->imageService->storePubliclyImage($image, $album, $username, $imageName);
            $url = $this->storageService->getImageUrl($path);

            $thumbnail = $this->imageService->createImageThumbnail($image, 270, 360);

            $stream = $this->imageService->createStream($thumbnail);

            $this->storageService->storeThumbnailImage($username, $albumPath, $imageName, $stream);

            $pathThumbnail = $this->pathService->createThumbnailPath($username, $albumPath, $imageName);

            $urlThumbnail = $this->storageService->getImageUrl($pathThumbnail);

            $imageId = $this->imageService->add($url, $path, $imageName, $pathThumbnail, $urlThumbnail, $albumId);

            array_push($result, [$imageName, $urlThumbnail, $imageId, $username, $albumId]);
        }

        return $result;
    }

    public function delete(Request $request) {

        $userId = Auth::id();
        $imageId = $request->query('id');
        $albumId = $request->query('album');
        $imagePath = $request->query('path');
        $thumbnail = $request->query('thumbnail');

        $this->imageService->deleteImage($userId, $albumId, $imageId);

        $this->storageService->deleteImage($imagePath);

        if ($thumbnail) {
            $this->storageService->deleteImage($thumbnail);
        }

        $this->favoriteService->delete($imageId);

        return response('ok', 200);
    }

    public function destroy(Request $request) {

        $url = $request->query('url');
        $path = $request->query('path');
        $userId = Auth::id();

        $this->imageService->deletePostImageByUrl($userId, 'posts', $url);

        $this->storageService->deleteImage($path);

        return response('ok', 200);
    }
}
