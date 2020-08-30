<?php

namespace App\Http\Controllers;

use App\Events\FriendRequest;
use App\Http\Requests\ConfirmRequest;
use App\Repositories\CachedUserRepository;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Services\FriendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeoService;
use App\User;

class PublicUsersController extends Controller
{
    protected $seoService;
    protected $friendService;
    protected $userRepository;

    public function __construct(SeoService $seoService, FriendService $friendService, CachedUserRepository $userRepository)
    {
        $this->seoService = $seoService;
        $this->friendService = $friendService;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request, $username) {

        $id = Auth::id();

        $seo = $this->seoService->getSeoData($request);

        $profiles = $this->userRepository->getAllPublicUsers($id);

        $currentUser = $this->userRepository->getUsersWithFriends($id);

        $confirmedFriends = $this->friendService->getConfirmedFriends($currentUser->friends);

        $requestedFriends = $this->friendService->getRequestedFriends($currentUser->friends);

        return view('user.public', compact('seo', 'profiles', 'currentUser', 'confirmedFriends', 'requestedFriends'));
    }

    public function store(ConfirmRequest $request)
    {
        $friend = $request->validated()['friend'];

        $authUserId = Auth::id();

        $this->friendService->addFriend($authUserId, $friend);

        broadcast(new FriendRequest(Auth::user(), User::find($friend)));

        return response('ok', 200);
    }
}
