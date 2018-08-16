<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Profile;

class PublicUsersController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->middleware('auth');
        $this->seoService = $seoService;
    }

    public function index(Request $request) {

        $seo = $this->seoService->getSeoData($request);
        $profiles = Profile::with('user')->where('public', true )->get();

        return view('user.public', compact('seo', 'profiles'));
    }
}
