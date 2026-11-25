<?php

namespace App\Http\Controllers;

use App\Events\FriendRequestSent;
use App\User;
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
        $friends = collect($this->userService->getUsersWithFriends($userId)['friends']);

        return view('user.public', [
            'seo' => $this->seoService->getSeoData($request),
            'profiles' => $this->userService->getAllPublicUsers($userId),
            'confirmedFriends' => $this->friendService->getConfirmedFriendsIds($friends),
            'incomingFriends' => $friends->where('owner', false)->where('confirmed', false)->pluck('friend_id')->all(),
            'requestedFriends' => $this->friendService->getRequestedFriendsIds($friends),
        ]);
    }

    public function store(FriendRequestRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $recipient = User::whereHas('profile', fn ($query) => $query->where('public', true))
            ->findOrFail($validated['friend_id']);

        if ($this->friendService->sendFriendRequest($user->id, $recipient->id)) {
            event(new FriendRequestSent($user, $recipient));
        }

        return response()->json(['status' => 'success']);
    }
}
