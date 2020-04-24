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

        return view('user.profile', compact('seo'));
    }

    public function requests(Request $request, $username) {

        $seo = $this->seoService->getSeoData($request);

        $friendRequest = $this->friendRepository->getFriendsRequests(Auth::id());

        return view('user.requests', compact('seo', 'friendRequest'));
    }

    public function settings(Request $request, $username)
    {

        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        return view('user.settings', compact('seo'));
    }

    public function friends(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;;

        $friendList = $this->friendRepository->getFriendsList(Auth::id());

        return view('user.friends', compact('seo', 'friendList'));
    }

    public function messages(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $friendList = $this->friendRepository->getFriendsList(Auth::id());

        return view('user.messages', compact('seo', 'friendList'));
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

        $friend = $this->userRepository->getMessageUser($friend);

        $type = 'post';

        $messages = $this->messageRepository->getMessages(Auth::id(), $friend->id);

        return view('user.friendmessages', compact('seo', 'friend', 'type', 'messages'));
    }
}
