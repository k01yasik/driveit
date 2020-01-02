<?php

namespace App\Http\Controllers;

use App\Repositories\CachedUserRepository;
use App\Repositories\FriendRepository;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\ConfirmFriendRequest;

class UserPageController extends Controller
{
    protected $seoService;
    protected $userRepository;
    protected $friendRepository;
    protected $messageRepository;

    public function __construct(SeoService $seoService,
                                CachedUserRepository $userRepository,
                                FriendRepository $friendRepository,
                                MessageRepository $messageRepository)
    {
        $this->seoService = $seoService;
        $this->userRepository = $userRepository;
        $this->friendRepository = $friendRepository;
        $this->messageRepository = $messageRepository;
    }

    public function index(Request $request, $username) {

        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = $this->userRepository->getMessageUser($username);

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = $this->friendRepository->getFriendsCount($currentUserId);

        return view('user.profile', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount'));
    }

    public function requests(Request $request, $username) {

        $seo = $this->seoService->getSeoData($request);

        $user = $this->userRepository->getMessageUser($username);

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequest = $this->friendRepository->getFriendsRequests($currentUserId);

        $friendRequestCount = $friendRequest->count();

        return view('user.requests', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount', 'friendRequest'));
    }

    public function settings(Request $request, $username) {

        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = $this->userRepository->getMessageUser($username);

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = $this->friendRepository->getFriendsCount($currentUserId);

        return view('user.settings', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount'));
    }

    public function friends(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = $this->userRepository->getMessageUser($username);

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = $this->friendRepository->getFriendsCount($currentUserId);

        $friendList = $this->friendRepository->getFriendsList($currentUserId);

        return view('user.friends', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount', 'friendList'));
    }

    public function messages(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $user = $this->userRepository->getMessageUser($username);

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = $this->friendRepository->getFriendsCount($currentUserId);

        $friendList = $this->friendRepository->getFriendsList($currentUserId);

        return view('user.messages', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount', 'friendList'));
    }

    public function update(Request $request) {

        $data = $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $data['id'];

        $user = Auth::user();

        $currentUserId = $user->id;

        $this->friendRepository->confirmUsers($id, $currentUserId);

        broadcast(new ConfirmFriendRequest($user, User::find($id)));

        return response('ok', 200);
    }

    public function friendMessages(Request $request, $username, $friend) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$friend;
        $seo['description'] = $seo['description'].' '.$friend;

        $user = $this->userRepository->getMessageUser($username);

        $friend = $this->userRepository->getMessageUser($friend);

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = $this->friendRepository->getFriendsCount($currentUserId);

        $type = 'post';

        $messages = $this->messageRepository->getMessages($currentUserId, $friend->id);

        return view('user.friendmessages', compact('seo', 'user', 'currentUserProfile', 'friendRequestCount', 'friend', 'type', 'messages'));
    }
}
