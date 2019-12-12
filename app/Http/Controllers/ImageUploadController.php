<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Requests\BodyImageUpload;
use App\Http\Requests\PostImageUpload;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Services\ImageService;
use App\Services\StorageService;
use App\Services\UploadImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AvatarImage;
use Illuminate\Http\UploadedFile;
use App\Services\PathService;

class ImageUploadController extends Controller
{
    protected $uploadImageService;
    protected $imageService;
    protected $storageService;
    protected $profileRepository;
    protected $albumRepository;
    protected $imageRepository;
    protected $pathService;
    protected $favoriteRepository;

    public function __construct(UploadImageService $uploadImageService,
                                ImageService $imageService,
                                StorageService $storageService,
                                ProfileRepositoryInterface $profileRepository,
                                AlbumRepositoryInterface $albumRepository,
                                ImageRepositoryInterface $imageRepository,
                                PathService $pathService,
                                FavoriteRepositoryInterface $favoriteRepository)
    {
        $this->uploadImageService = $uploadImageService;
        $this->imageService = $imageService;
        $this->storageService = $storageService;
        $this->profileRepository = $profileRepository;
        $this->albumRepository = $albumRepository;
        $this->imageRepository = $imageRepository;
        $this->pathService = $pathService;
        $this->favoriteRepository = $favoriteRepository;
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

    /**
     * @param AvatarImage $request
     * @property UploadedFile $image
     * @return string
     */
    public function avatar(AvatarImage $request) {

        $data = $request->validated();

        $image = $data['avatar_upload'];

        $user = Auth::user();
        $username = $user->username;
        $imageName = $image->getClientOriginalName();
        $avatar = $this->imageService->createThumbnail($image, $data['width'], $data['height'], $data['x'], $data['y']);

        $stream = $this->imageService->createStream($avatar);

        $this->storageService->storeImage($username, $imageName, $stream);

        $avatarPath = $this->pathService->createAvatarPath($username, $imageName);
        $avatarUrl =  $this->storageService->getImageUrl($avatarPath);

        $profile = $this->profileRepository->store($user, $avatarUrl);

        event('eloquent.saved: App\Profile', $profile);

        return $avatarUrl;
    }

    public function image(Request $request) {

        $username = Auth::user()->username;

        $images = $request->images_upload;
        $albumName = $request->album_name;

        $album = $this->albumRepository->getUserAlbumByName($albumName);
        $albumPath = $album->path;
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

            $imageId = $this->imageRepository->store($url, $path, $imageName, $pathThumbnail, $urlThumbnail, $album);

            array_push($result, [$imageName, $urlThumbnail, $imageId, $username, $album->id]);
        }

        return $result;
    }

    public function delete(Request $request) {

        $user = Auth::user();
        $imageId = $request->query('id');
        $albumId = $request->query('album');

        $image = $this->imageRepository->getUserImage($user, $albumId, $imageId);

        $this->storageService->deleteImage($image->path);

        if ($image->path_thumbnail) {
            $this->storageService->deleteImage($image->path_thumbnail);
        }

        try {
            $image->delete();
        } catch (\Exception $e) {
        }

        $this->favoriteRepository->delete($imageId);

        return response('ok', 200);
    }

    public function destroy(Request $request) {

        $url = $request->query('url');
        $user = Auth::user();

        $image = $this->imageRepository->getPostImage($user, 'posts', $url);

        if ($image) {
            $this->storageService->deleteImage($image->path);
        }

        return response('ok', 200);
    }
}
