<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAlbumRequest;
use App\Services\AlbumService;
use App\Services\FriendService;
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
        private FriendService $friendService,
        private AlbumService $albumService,
        private ImageService $imageService
    ) {}

    public function index(Request $request, string $username)
    {
        $seo = $this->seoService->prepareSeoData($request, $username);
        $user = $this->userService->getUserForAlbums($username);
        $currentUserId = Auth::id();
        
        return view('user.albums.index', [
            'seo' => $seo,
            'user' => $user,
            'currentUserProfile' => $user->id === $currentUserId,
            'friendRequestCount' => $this->friendService->getFriendsCount($currentUserId)
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
        $album = $this->albumService->getUserAlbumByName($albumname, Auth::id());
        
        return view('user.albums.show', [
            'seo' => $this->seoService->prepareSeoData($request, $album->name),
            'images' => $this->imageService->getAllAlbumImages($album->id),
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
