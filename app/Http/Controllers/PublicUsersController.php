<?php

namespace App\Http\Controllers;

use App\Events\FriendRequest;
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
        $this->seoService = $seoService;
        $this->friendService = $friendService;
    }

    public function index(Request $request, $username) {

        $currentUserId = Auth::id();
        $seo = $this->seoService->getSeoData($request);

        $profiles = Profile::with(['user', 'user.friends'])->where([['public', true], ['user_id', '!=', $currentUserId]] )->get();

        $currentUser = User::with('friends')->find($currentUserId);

        $confirmedFriends = $this->friendService->getConfirmedFriends($currentUser->friends);

        $requestedFriends = $this->friendService->getRequestedFriends($currentUser->friends);

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = Friend::where([['friend_id', $currentUserId], ['confirmed', 0], ['owner', 1]])->get()->count();

        return view('user.public', compact('seo', 'profiles', 'currentUser', 'confirmedFriends', 'requestedFriends', 'user', 'currentUserProfile', 'friendRequestCount'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'friend' => 'required|integer',
        ]);

        $currentUserId = Auth::id();

        $friend = new Friend;
        $friend->user_id = $currentUserId;
        $friend->friend_id = $data['friend'];
        $friend->owner = true;
        $friend->save();

        $friend = new Friend;
        $friend->user_id = $data['friend'];
        $friend->friend_id = $currentUserId;
        $friend->owner = false;
        $friend->save();

        broadcast(new FriendRequest(Auth::user(), User::find($data['friend'])));

        return 'ok';
    }
}
