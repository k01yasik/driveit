<?php

namespace App\Http\Controllers;

use App\Events\ConfirmFriendRequest;
use App\Services\UserService;
use App\Services\FriendService;
use App\Services\MessageService;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserPageController extends Controller
{
    public function __construct(
        private SeoService $seoService,
        private UserService $userService,
        private FriendService $friendService,
        private MessageService $messageService
    ) {}

    public function index(Request $request, string $username)
    {
        $seo = $this->seoService->getSeoData($request, $username);
        return view('user.profile', compact('seo'));
    }

    public function requests(Request $request, string $username)
    {
        $seo = $this->seoService->getSeoData($request);
        $friendRequests = $this->friendService->getPendingRequests(Auth::id());

        return view('user.requests', compact('seo', 'friendRequests'));
    }

    public function settings(Request $request, string $username)
    {
        $seo = $this->seoService->getSeoData($request, $username);
        return view('user.settings', compact('seo'));
    }

    public function updateSettings(Request $request, string $username)
    {
        $validated = $request->validate(['public' => 'required|boolean']);
        $profile = $request->user()->profile()->firstOrFail();
        $profile->public = (bool) $validated['public'];
        $profile->save();

        return redirect()->route('user.settings', $username);
    }

    public function friends(Request $request, string $username)
    {
        $seo = $this->seoService->getSeoData($request, $username);
        $friendList = $this->friendService->getFriends($request->attributes->get('profileUser')->id);

        return view('user.friends', compact('seo', 'friendList'));
    }

    public function messages(Request $request, string $username)
    {
        $seo = $this->seoService->getSeoData($request, $username);
        $friendList = $this->friendService->getFriends(Auth::id());

        return view('user.messages', compact('seo', 'friendList'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate(['id' => 'required|integer|exists:users,id|not_in:'.Auth::id()]);
        $user = Auth::user();

        if ($this->friendService->acceptFriendRequest($validated['id'], $user->id)) {
            event(new ConfirmFriendRequest($user, User::findOrFail($validated['id'])));
        }

        return response()->noContent();
    }

    public function friendMessages(Request $request, string $username, string $friendUsername)
    {
        $seo = $this->seoService->getSeoData($request, $friendUsername);
        $friend = $this->userService->getMessageUser($friendUsername);
        $messages = $this->messageService->getConversation(Auth::id(), $friend['id']);

        return view('user.friendmessages', [
            'seo' => $seo,
            'friend' => $friend,
            'type' => 'post',
            'canSendMessages' => $this->friendService->areFriends(Auth::id(), $friend['id']),
            'messages' => $messages,
            'messagesCount' => count($messages),
        ]);
    }
}
