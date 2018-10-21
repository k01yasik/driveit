<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAlbumRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeoService;
use App\User;
use App\Album;
use App\Image;

class UserAlbumsController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = User::with('profile', 'albums', 'albums.images')->where('username', $username)->firstOrFail();

        $currentUserProfile = $user->id === Auth::id();

        return view('user.albums.index', compact('seo', 'user', 'currentUserProfile'));
    }

    public function create(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);
        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserProfile = $user->id === Auth::id();

        return view('user.albums.create', compact('seo', 'user', 'currentUserProfile'));
    }

    public function show(Request $request, $username, $albumname) {
        $seo = $this->seoService->getSeoData($request);


        $album = Album::where([['name', $albumname], ['user_id', Auth::id()]])->firstOrFail();
        $images = Image::with('favorites')->where('album_id', $album->id)->orderByDesc('created_at')->get();

        $seo['title'] = $seo['title'].' '.$album->name;
        $seo['description'] = $seo['description'].' '.$album->name;

        $user = User::with('profile', 'albums')->where('username', $username)->firstOrFail();

        $currentUserProfile = $user->id === Auth::id();

        return view('user.albums.show', compact('seo', 'user', 'currentUserProfile', 'images', 'album'));
    }

    public function store(NewAlbumRequest $request, $username) {
        $data = $request->validated();

        $album_name = $data['name'];

        $album = new Album;
        $album->name = $album_name;
        $album->path = str_random(10);
        $album->user_id = Auth::id();
        $album->save();

        return redirect()->route('user.albums.index', ['username' => $username]);
    }

    public function edit(Request $request, $username, $albumname) {
        $seo = $this->seoService->getSeoData($request);

        $user = User::with('profile')->where('username', $username)->firstOrFail();
        $album = Album::where([['user_id', Auth::id()], ['name', $albumname]])->firstOrFail();

        $currentUserProfile = $user->id === Auth::id();

        return view('user.albums.edit', compact('seo', 'user', 'currentUserProfile', 'album'));
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
