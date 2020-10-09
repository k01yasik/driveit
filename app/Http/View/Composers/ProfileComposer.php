<?php


namespace App\Http\View\Composers;

use App\Services\FriendService;
use App\Services\UserService;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileComposer
{
    protected UserService $userService;
    protected FriendService $friendService;

    public function __construct(UserService $userService,
                                FriendService $friendService)
    {
        $this->userService = $userService;
        $this->friendService = $friendService;
    }

    public function compose(View $view)
    {
        $user = $this->userService
            ->getMessageUser(request()->route()->parameter('username'));

        $currentUserId = Auth::id();

        $currentUserProfile = $user['id'] === $currentUserId;

        $friendRequestCount = $this->friendService
            ->getFriendsCount($currentUserId);
        $view->with('user', $user)
            ->with('currentUserProfile', $currentUserProfile)
            ->with('friendRequestCount', $friendRequestCount);
    }
}
