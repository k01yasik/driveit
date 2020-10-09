<?php

namespace App\Http\Controllers;

use App\Events\FriendRequest;
use App\Http\Requests\ConfirmRequest;
use App\Repositories\CachedUserRepository;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Services\FriendService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeoService;
use App\User;

class PublicUsersController extends Controller
{
    protected SeoService $seoService;
    protected FriendService $friendService;
    protected UserService $userService;

    public function __construct(SeoService $seoService, FriendService $friendService, UserService $userService)
    {
        $this->seoService = $seoService;
        $this->friendService = $friendService;
        $this->userService = $userService;
    }

    public function index(Request $request, $username) {

        $id = Auth::id();

        $seo = $this->seoService->getSeoData($request);

        $profiles = $this->userService->getAllPublicUsers($id);

        $currentUser = $this->userService->getUsersWithFriends($id);

        $confirmedFriends = $this->friendService->getConfirmedFriends($currentUser['friends']);

        $requestedFriends = $this->friendService->getRequestedFriends($currentUser['friends']);

        return view('user.public', compact('seo', 'profiles', 'currentUser', 'confirmedFriends', 'requestedFriends'));
    }

    public function store(ConfirmRequest $request)
    {
        $friend = $request->validated()['friend'];

        $user = Auth::user();

        $this->friendService->addFriend($user->id, $friend);

        broadcast(new FriendRequest($user, User::find($friend)));

        return response('ok', 200);
    }
}
