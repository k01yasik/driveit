<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAlbumRequest;
use App\Services\AlbumService;
use App\Services\ImageService;
use App\Services\SeoService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAlbumsController extends Controller
{
    public function __construct(
        private SeoService $seoService,
        private UserService $userService,
        private AlbumService $albumService,
        private ImageService $imageService
    ) {}

    public function index(Request $request, string $username)
    {
        return view('user.albums.index', [
            'seo' => $this->seoService->getSeoData($request, $username),
            'user' => $this->userService->getUserForAlbums($username),
        ]);
    }

    public function create(Request $request)
    {
        return view('user.albums.create', [
            'seo' => $this->seoService->getSeoData($request)
        ]);
    }

    public function show(Request $request, string $username, string $albumname)
    {
        $album = $this->albumService->getUserAlbumByName($albumname, $request->attributes->get('profileUser')->id);

        return view('user.albums.show', [
            'seo' => $this->seoService->getSeoData($request, $album->name),
            'images' => $this->imageService->getAlbumImages($album->id),
            'album' => $album
        ]);
    }

    public function store(NewAlbumRequest $request, string $username)
    {
        $cleanAlbumName = clean($request->validated()['name']);
        $this->albumService->createAlbum($cleanAlbumName, Auth::id());

        return redirect()->route('user.albums.index', compact('username'));
    }

    public function edit(Request $request, string $username, string $albumname)
    {
        $album = $this->albumService->getUserAlbumByName($albumname, Auth::id());

        return view('user.albums.edit', [
            'seo' => $this->seoService->getSeoData($request),
            'album' => $album
        ]);
    }

    public function update(NewAlbumRequest $request, string $username, string $albumname)
    {
        $cleanAlbumName = clean($request->validated()['name']);
        $this->albumService->updateName($albumname, $cleanAlbumName, Auth::id());

        return redirect()->route('user.albums.index', compact('username'));
    }
}
