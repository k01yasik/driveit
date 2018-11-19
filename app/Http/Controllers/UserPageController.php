<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\User;
use App\Friend;
use App\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\ConfirmFriendRequest;

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

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = Friend::where([['friend_id', $currentUserId], ['confirmed', 0], ['owner', 1]])->get()->count();

        return view('user.profile', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount'));
    }

    public function requests(Request $request, $username) {

        $seo = $this->seoService->getSeoData($request);

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequest = Friend::with(['user', 'user.profile'])->where([['friend_id', $currentUserId], ['confirmed', 0], ['owner', 1]])->get();

        $friendRequestCount = $friendRequest->count();

        return view('user.requests', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount', 'friendRequest'));
    }

    public function settings(Request $request, $username) {

        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = Friend::where([['friend_id', $currentUserId], ['confirmed', 0], ['owner', 1]])->get()->count();

        return view('user.settings', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount'));
    }

    public function friends(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = Friend::where([['friend_id', $currentUserId], ['confirmed', 0], ['owner', 1]])->get()->count();

        $friendList = Friend::with(['user', 'user.profile'])->where([['friend_id', $currentUserId], ['confirmed', 1]])->get();

        return view('user.friends', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount', 'friendList'));
    }

    public function messages(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = Friend::where([['friend_id', $currentUserId], ['confirmed', 0], ['owner', 1]])->get()->count();

        $friendList = Friend::with(['user', 'user.profile'])->where([['friend_id', $currentUserId], ['confirmed', 1]])->get();

        return view('user.messages', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount', 'friendList'));
    }

    public function update(Request $request) {

        $data = $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $data['id'];

        $currentUserId = Auth::id();

        $friend = Friend::where([['user_id', $id], ['friend_id', $currentUserId]])->firstOrFail();
        $friend->confirmed = true;
        $friend->save();

        $friend = Friend::where([['user_id', $currentUserId], ['friend_id', $id]])->firstOrFail();
        $friend->confirmed = true;
        $friend->save();

        broadcast(new ConfirmFriendRequest(Auth::user(), User::find($id)));

        return 'ok';
    }

    public function friendMessages(Request $request, $username, $friend) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$friend;
        $seo['description'] = $seo['description'].' '.$friend;

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $friend = User::with('profile')->where('username', $friend)->firstOrFail();

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = Friend::where([['friend_id', $currentUserId], ['confirmed', 0], ['owner', 1]])->get()->count();

        $type = 'post';

        $messages = Message::with(['user', 'user.profile', 'friend', 'friend.profile'])
            ->where([['user_id', $currentUserId], ['friend_id', $friend->id]])
            ->orWhere([['user_id', $friend->id], ['friend_id', $currentUserId]])
            ->orderBy('created_at')
            ->get();

        return view('user.friendmessages', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount', 'friend', 'type', 'messages'));
    }
}
