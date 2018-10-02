<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\User;

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

        return view('user.profile', compact('seo', 'user'));
    }

    public function settings($username) {
        return view('user.settings');
    }

    public function friends($username) {
        return view('user.friends');
    }

    public function messages($username) {
        return view('user.messages');
    }

    public function friendMessages($username, $friend) {
        return view('user.friendmessages');
    }
}
