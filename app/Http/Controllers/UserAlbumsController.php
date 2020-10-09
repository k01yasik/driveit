<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAlbumRequest;
use App\Repositories\AlbumRepository;
use App\Repositories\CachedUserRepository;
use App\Repositories\FriendRepository;
use App\Repositories\ImageRepository;
use App\Services\AlbumService;
use App\Services\FriendService;
use App\Services\ImageService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeoService;
use App\User;
use App\Album;
use App\Friend;


class UserAlbumsController extends Controller
{
    protected SeoService $seoService;
    protected UserService $userService;
    protected FriendService $friendService;
    protected AlbumService $albumService;
    protected ImageService $imageService;

    public function __construct(SeoService $seoService,
                                UserService $userService,
                                FriendService $friendService,
                                AlbumService $albumService,
                                ImageService $imageService)
    {
        $this->seoService = $seoService;
        $this->userService = $userService;
        $this->friendService = $friendService;
        $this->albumService = $albumService;
        $this->imageService = $imageService;
    }

    public function index(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = $this->userService->getUserForAlbums($username);

        $currentUserId = Auth::id();

        $currentUserProfile = $user['id'] === $currentUserId;

        $friendRequestCount = $this->friendService->getFriendsCount($currentUserId);

        return view('user.albums.index', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount'));
    }

    public function create(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        return view('user.albums.create', compact('seo'));
    }

    public function show(Request $request, $username, $albumname) {
        $seo = $this->seoService->getSeoData($request);


        $album = $this->albumService->getUserAlbumByName($albumname, Auth::id());
        $images = $this->imageService->getAllAlbumImages($album['id']);

        $seo['title'] = $seo['title'].' '.$album['name'];
        $seo['description'] = $seo['description'].' '.$album['name'];

        return view('user.albums.show', compact('seo',  'images', 'album'));
    }

    public function store(NewAlbumRequest $request, $username) {
        $albumName = $request->validated()['name'];

        $cleanAlbumName = clean($albumName);

        $this->albumService->save($cleanAlbumName, Auth::id());

        return redirect()->route('user.albums.index', ['username' => $username]);
    }

    public function edit(Request $request, $username, $albumname) {
        $seo = $this->seoService->getSeoData($request);

        $album = $this->albumService->getUserAlbumByName($albumname, Auth::id());

        return view('user.albums.edit', compact('seo', 'album'));
    }

    public function update(NewAlbumRequest $request, $username, $albumname) {
        $albumName = $request->validated()['name'];

        $cleanAlbumName = clean($albumName);

        $this->albumService->updateName($albumname, $cleanAlbumName, Auth::id());

        return redirect()->route('user.albums.index', ['username' => $username]);
    }
}
