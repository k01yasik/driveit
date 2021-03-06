<?php

namespace App\Http\Controllers;

use App\Repositories\CachedUserRepository;
use App\Services\FriendService;
use App\Services\MessageService;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\ConfirmFriendRequest;
use Illuminate\Support\Facades\Log;

class UserPageController extends Controller
{
    protected SeoService $seoService;
    protected CachedUserRepository $userRepository;
    protected FriendService $friendService;
    protected MessageService $messageService;

    public function __construct(SeoService $seoService,
                                CachedUserRepository $userRepository,
                                FriendService $friendService,
                                MessageService $messageService)
    {
        $this->seoService = $seoService;
        $this->userRepository = $userRepository;
        $this->friendService = $friendService;
        $this->messageService = $messageService;
    }

    public function index(Request $request, $username) {

        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        return view('user.profile', compact('seo'));
    }

    public function requests(Request $request, $username): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        $seo = $this->seoService->getSeoData($request);

        $friendRequest = $this->friendService->getFriendsRequests(Auth::id());

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

        $friendList = $this->friendService->getFriendsList(Auth::id());

        return view('user.friends', compact('seo', 'friendList'));
    }

    public function messages(Request $request, $username) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        $friendList = $this->friendService->getFriendsList(Auth::id());

        return view('user.messages', compact('seo', 'friendList'));
    }

    public function update(Request $request) {

        $data = $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $data['id'];

        $user = Auth::user();

        $currentUserId = $user->id;

        $this->friendService->confirmUsers($id, $currentUserId);

        broadcast(new ConfirmFriendRequest($user, User::find($id)));

        return response('ok', 200);
    }

    public function friendMessages(Request $request, $username, $friend) {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$friend;
        $seo['description'] = $seo['description'].' '.$friend;

        $friend = $this->userRepository->getMessageUser($friend);

        $type = 'post';

        $messages = $this->messageService->getMessages(Auth::id(), $friend->id);

        $messagesCount = $messages.count();

        return view('user.friendmessages', compact('seo', 'friend', 'type', 'messages', 'messagesCount'));
    }
}
