<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAlbumRequest;
use App\Repositories\AlbumRepository;
use App\Repositories\CachedUserRepository;
use App\Repositories\FriendRepository;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeoService;
use App\User;
use App\Album;
use App\Image;
use App\Friend;
use Illuminate\Support\Str;

class UserAlbumsController extends Controller
{
    protected $seoService;
    protected $userRepository;
    protected $friendRepository;
    protected $albumRepository;
    protected $imageRepository;

    public function __construct(SeoService $seoService,
                                CachedUserRepository $userRepository,
                                FriendRepository $friendRepository,
                                AlbumRepository $albumRepository,
                                ImageRepository $imageRepository)
    {
        $this->seoService = $seoService;
        $this->userRepository = $userRepository;
        $this->friendRepository = $friendRepository;
        $this->albumRepository = $albumRepository;
        $this->imageRepository = $imageRepository;
    }

    public function index(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = $this->userRepository->getUserForAlbums($username);

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = $this->friendRepository->getFriendsCountToUserAlbums($currentUserId);

        return view('user.albums.index', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount'));
    }

    public function create(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userRepository->getMessageUser($username);

        $id = Auth::id();

        $currentUserProfile = $user->id === $id;

        $friendRequestCount = $this->friendRepository->getFriendsCountToUserAlbums($id);

        return view('user.albums.create', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount'));
    }

    public function show(Request $request, $username, $albumname) {
        $seo = $this->seoService->getSeoData($request);


        $album = $this->albumRepository->getUserAlbumByName($albumname);
        $images = $this->imageRepository->getAllAlbumImages($album->id);

        $seo['title'] = $seo['title'].' '.$album->name;
        $seo['description'] = $seo['description'].' '.$album->name;

        $user = User::with('profile', 'albums')->where('username', $username)->firstOrFail();

        $id = Auth::id();

        $currentUserProfile = $user->id === $id;

        $friendRequestCount = $this->friendRepository->getFriendsCountToUserAlbums($id);

        return view('user.albums.show', compact('seo', 'user', 'currentUserProfile', 'images', 'album', 'friendRequestCount'));
    }

    public function store(NewAlbumRequest $request, $username) {
        $data = $request->validated();

        $album_name = $data['name'];

        $album = new Album;
        $album->name = $album_name;
        $album->path = Str::random(10);
        $album->user_id = Auth::id();
        $album->save();

        return redirect()->route('user.albums.index', ['username' => $username]);
    }

    public function edit(Request $request, $username, $albumname) {
        $seo = $this->seoService->getSeoData($request);

        $user = User::with('profile')->where('username', $username)->firstOrFail();
        $album = Album::where([['user_id', Auth::id()], ['name', $albumname]])->firstOrFail();

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = Friend::where([['friend_id', $currentUserId], ['confirmed', 0]])->get()->count();

        return view('user.albums.edit', compact('seo', 'user', 'currentUserProfile', 'album', 'friendRequestCount'));
    }

    public function update(NewAlbumRequest $request, $username, $albumname) {
        $data = $request->validated();

        $album_name = $data['name'];

        $album = Auth::user()->albums()->where('name', $albumname)->firstOrFail();

        $album->name = $album_name;
        $album->save();

        return redirect()->route('user.albums.index', ['username' => $username]);
    }
}
