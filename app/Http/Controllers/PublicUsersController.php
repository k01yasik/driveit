<?php

namespace App\Http\Controllers;

use App\Services\FriendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeoService;
use App\Profile;
use App\Friend;
use App\User;

class PublicUsersController extends Controller
{
    protected $seoService;
    protected $friendService;

    public function __construct(SeoService $seoService, FriendService $friendService)
    {
        $this->middleware('auth');
        $this->seoService = $seoService;
        $this->friendService = $friendService;
    }

    public function index(Request $request) {

        $seo = $this->seoService->getSeoData($request);
        $profiles = Profile::with(['user', 'user.friends'])->where('public', true )->get();
        $currentUser = User::with('friends')->find(Auth::id());

        $confirmedFriends = $this->friendService->getConfirmedFriends($currentUser->friends);
        $requestedFriends = $this->friendService->getRequestedFriends($currentUser->friends);

        return view('user.public', compact('seo', 'profiles', 'currentUser', 'confirmedFriends', 'requestedFriends'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'friend' => 'required|integer',
        ]);

        $friend = new Friend;
        $friend->friend_id = $data['friend'];

        Auth::user()->friends()->save($friend);

        return redirect()->back();
    }
}
