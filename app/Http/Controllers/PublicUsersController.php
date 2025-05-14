<?php

namespace App\Http\Controllers;

use App\Events\FriendRequestSent;
use App\Http\Requests\FriendRequestRequest;
use App\Services\FriendService;
use App\Services\SeoService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicUsersController extends Controller
{
    public function __construct(
        private SeoService $seoService,
        private FriendService $friendService,
        private UserService $userService
    ) {
    }

    public function index(Request $request, string $username)
    {
        $userId = Auth::id();

        return view('user.public', [
            'seo' => $this->seoService->getSeoData($request),
            'profiles' => $this->userService->getAllPublicUsers($userId),
            'currentUser' => $this->userService->getUserWithFriends($userId),
            'confirmedFriends' => $this->friendService->getConfirmedFriendsIds(
                $this->userService->getUserFriends($userId)
            ),
            'requestedFriends' => $this->friendService->getRequestedFriendsIds(
                $this->userService->getUserFriends($userId)
            ),
        ]);
    }

    public function store(FriendRequestRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $this->friendService->sendFriendRequest($user->id, $validated['friend_id']);

        event(new FriendRequestSent($user, User::find($validated['friend_id'])));

        return response()->json(['status' => 'success']);
    }
}
