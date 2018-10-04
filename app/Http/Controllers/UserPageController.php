<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserPageController extends Controller
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

        return view('user.profile', compact('seo', 'user', 'currentUserProfile'));
    }

    public function settings(Request $request, $username) {

        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserProfile = $user->id == Auth::id();

        return view('user.settings', compact('seo', 'user', 'currentUserProfile'));
    }

    public function friends(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserProfile = $user->id == Auth::id();

        return view('user.friends', compact('seo', 'user', 'currentUserProfile'));
    }

    public function messages($username) {
        return view('user.messages');
    }

    public function friendMessages($username, $friend) {
        return view('user.friendmessages');
    }
}
