<?php

namespace App\Http\Controllers;

use App\Events\ConfirmFriendRequest;
use App\Services\UserService;
use App\Services\FriendService;
use App\Services\MessageService;
use App\Services\SeoService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\User;

class UserPageController extends Controller
{
    public function __construct(
        private SeoService $seoService,
        private UserService $userService,
        private FriendService $friendService,
        private MessageService $messageService,
        private ProfileService $profileService
    ) {}

    public function index(Request $request, string $username)
    {
        $seo = $this->seoService->getSeoData($request, $username);
        $cars = $request->attributes->get('profileUser')->cars()->with('album:id,name')->orderBy('id')->get();

        return view('user.profile', compact('seo', 'cars'));
    }

    public function requests(Request $request, string $username)
    {
        $seo = $this->seoService->getSeoData($request);
        $friendRequests = $this->friendService->getPendingRequests(Auth::id());

        $outgoingRequests = $this->friendService->getOutgoingRequests(Auth::id());

        return view('user.requests', compact('seo', 'friendRequests', 'outgoingRequests'));
    }

    public function dismissRequest(Request $request, string $username, int $id)
    {
        $data = $request->validate(['outgoing' => 'required|boolean']);
        $this->friendService->dismissRequest(Auth::id(), $id, (bool) $data['outgoing']);

        return redirect()->route('user.requests', $username);
    }

    public function removeFriend(Request $request, string $username, int $id)
    {
        $this->friendService->removeFriend(Auth::id(), $id);

        return redirect()->route('user.friends', $username);
    }

    public function settings(Request $request, string $username)
    {
        $seo = $this->seoService->getSeoData($request, $username);
        $user = $request->user();
        if (!$user->profile) {
            $user->setRelation('profile', $this->profileService->initialize($user));
        }
        $albums = $user->albums()->orderBy('name')->get(['id', 'name']);
        $cars = $user->cars()->orderBy('id')->get();

        return view('user.settings', compact('seo', 'albums', 'cars'));
    }

    public function updateSettings(Request $request, string $username)
    {
        $validated = $request->validate(['public' => 'required|boolean']);
        $this->profileService->updateVisibility($request->user()->id, (bool) $validated['public']);

        return redirect()->route('user.settings', $username);
    }

    public function updateProfile(Request $request, string $username)
    {
        $data = $request->validate([
            'first_name' => 'present|nullable|string|max:100',
            'last_name' => 'present|nullable|string|max:100',
            'city' => 'present|nullable|string|max:100',
            'about' => 'present|nullable|string|max:2000',
        ]);

        $this->profileService->updateDetails($request->user()->id, $data);

        return redirect()->route('user.settings', $username)->with('profileSaved', true);
    }

    public function addCar(Request $request, string $username)
    {
        $request->user()->cars()->create($this->validateCar($request));

        return redirect()->route('user.settings', $username);
    }

    public function updateCar(Request $request, string $username, int $car)
    {
        $car = $request->user()->cars()->findOrFail($car);
        $car->update($this->validateCar($request));

        return redirect()->route('user.settings', $username);
    }

    public function removeCar(Request $request, string $username, int $car)
    {
        $request->user()->cars()->findOrFail($car)->delete();

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
        $userId = Auth::id();
        $threads = $this->messageService->getThreads($userId);

        foreach ($this->friendService->getFriends($userId) as $friendship) {
            $threads[$friendship->user_id] ??= ['user' => $friendship->user, 'latest' => null, 'unread' => 0];
        }

        return view('user.messages', compact('seo', 'threads'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate(['id' => 'required|integer|exists:users,id|not_in:'.Auth::id()]);
        $user = Auth::user();

        if ($this->friendService->acceptFriendRequest($validated['id'], $user->id)) {
            event(new ConfirmFriendRequest($user, User::findOrFail($validated['id'])));
        }

        return $request->expectsJson()
            ? response()->noContent()
            : redirect()->route('user.requests', $user->username);
    }

    public function readMessage(Request $request, string $username, string $friend)
    {
        $validated = $request->validate(['id' => 'required|integer|min:1']);
        $sender = $this->userService->getMessageUser($friend);
        $this->messageService->markRead(Auth::id(), $sender['id'], $validated['id']);

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

    private function validateCar(Request $request): array
    {
        return $request->validate([
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'nullable|integer|min:1886|max:'.(now()->year + 1),
            'album_id' => ['nullable', 'integer', Rule::exists('albums', 'id')->where('user_id', $request->user()->id)],
        ]);
    }

}
