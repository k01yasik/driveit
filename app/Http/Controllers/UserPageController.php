<?php

namespace App\Http\Controllers;

use App\Events\ConfirmFriendRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\FriendService;
use App\Services\MessageService;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserPageController extends Controller
{
    private SeoService $seoService;
    private UserRepositoryInterface $userRepository;
    private FriendService $friendService;
    private MessageService $messageService;

    public function __construct(
        SeoService $seoService,
        UserRepositoryInterface $userRepository,
        FriendService $friendService,
        MessageService $messageService
    ) {
        $this->seoService = $seoService;
        $this->userRepository = $userRepository;
        $this->friendService = $friendService;
        $this->messageService = $messageService;
    }

    public function index(Request $request, string $username)
    {
        $seo = $this->getSeoWithUsername($request, $username);
        return view('user.profile', compact('seo'));
    }

    public function requests(Request $request, string $username)
    {
        $seo = $this->getSeoData($request);
        $friendRequests = $this->friendService->getFriendsRequests(Auth::id());
        
        return view('user.requests', compact('seo', 'friendRequests'));
    }

    public function settings(Request $request, string $username)
    {
        $seo = $this->getSeoWithUsername($request, $username);
        return view('user.settings', compact('seo'));
    }

    public function friends(Request $request, string $username)
    {
        $seo = $this->getSeoWithUsername($request, $username);
        $friendList = $this->friendService->getFriendsList(Auth::id());
        
        return view('user.friends', compact('seo', 'friendList'));
    }

    public function messages(Request $request, string $username)
    {
        $seo = $this->getSeoWithUsername($request, $username);
        $friendList = $this->friendService->getFriendsList(Auth::id());
        
        return view('user.messages', compact('seo', 'friendList'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate(['id' => 'required|integer']);
        $user = Auth::user();

        $this->friendService->confirmUsers($validated['id'], $user->id);
        broadcast(new ConfirmFriendRequest($user, User::find($validated['id'])));

        return response()->noContent();
    }

    public function friendMessages(Request $request, string $username, string $friendUsername)
    {
        $seo = $this->getSeoWithUsername($request, $friendUsername);
        $friend = $this->userRepository->getMessageUser($friendUsername);
        $messages = $this->messageService->getConversation(Auth::id(), $friend->id);

        return view('user.friendmessages', [
            'seo' => $seo,
            'friend' => $friend,
            'type' => 'post',
            'messages' => $messages,
            'messagesCount' => count($messages),
        ]);
    }

    private function getSeoWithUsername(Request $request, string $username): array
    {
        $seo = $this->getSeoData($request);
        $seo['title'] .= ' ' . $username;
        $seo['description'] .= ' ' . $username;
        
        return $seo;
    }

    private function getSeoData(Request $request): array
    {
        return $this->seoService->getSeoData($request);
    }
}
