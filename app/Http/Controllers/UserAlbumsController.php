<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAlbumRequest;
use App\Repositories\AlbumRepository;
use App\Repositories\CachedUserRepository;
use App\Repositories\FriendRepository;
use App\Repositories\ImageRepository;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeoService;
use App\User;
use App\Album;
use App\Friend;


class UserAlbumsController extends Controller
{
    protected $seoService;
    protected $userRepository;
    protected $friendRepository;
    protected $albumRepository;
    protected $imageService;

    public function __construct(SeoService $seoService,
                                CachedUserRepository $userRepository,
                                FriendRepository $friendRepository,
                                AlbumRepository $albumRepository,
                                ImageService $imageService)
    {
        $this->seoService = $seoService;
        $this->userRepository = $userRepository;
        $this->friendRepository = $friendRepository;
        $this->albumRepository = $albumRepository;
        $this->imageService = $imageService;
    }

    public function index(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        return view('user.albums.index', compact('seo'));
    }

    public function create(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        return view('user.albums.create', compact('seo'));
    }

    public function show(Request $request, $username, $albumname) {
        $seo = $this->seoService->getSeoData($request);


        $album = $this->albumRepository->getUserAlbumByName($albumname, Auth::id());
        $images = $this->imageService->getAllAlbumImages($album['id']);

        $seo['title'] = $seo['title'].' '.$album['name'];
        $seo['description'] = $seo['description'].' '.$album['name'];

        return view('user.albums.show', compact('seo',  'images', 'album'));
    }

    public function store(NewAlbumRequest $request, $username) {
        $data = $request->validated();

        $album_name = $data['name'];

        $album_name = clean($album_name);

        $this->albumRepository->save($album_name, Auth::id());

        return redirect()->route('user.albums.index', ['username' => $username]);
    }

    public function edit(Request $request, $username, $albumname) {
        $seo = $this->seoService->getSeoData($request);

        $album = $this->albumRepository->getUserAlbumByName($albumname, Auth::id());

        return view('user.albums.edit', compact('seo', 'album'));
    }

    public function update(NewAlbumRequest $request, $username, $albumname) {
        $data = $request->validated();

        $album_name = $data['name'];

        $album_name = clean($album_name);

        $album = $this->albumRepository->getUserAlbumByName($albumname, Auth::id());

        $album->name = $album_name;

        $album->save();

        return redirect()->route('user.albums.index', ['username' => $username]);
    }
}
