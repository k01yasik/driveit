<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeoService;
use App\User;

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

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserProfile = $user->id == Auth::id();

        return view('user.albums.index', compact('seo', 'user', 'currentUserProfile'));
    }

    public function create($username) {
        return view('user.albums.create');
    }

    public function show($username, $albumname) {
        return view('user.albums.show');
    }

    public function edit($username, $albumname) {
        return view('user.albums.edit');
    }
}
