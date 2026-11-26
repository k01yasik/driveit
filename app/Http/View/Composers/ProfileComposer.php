<?php


namespace App\Http\View\Composers;

use App\MaintenanceReminder;
use App\Services\FriendService;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileComposer
{
    protected UserService $userService;
    protected FriendService $friendService;

    public function __construct(UserService $userService,
                                FriendService $friendService,
                                private MessageService $messageService)
    {
        $this->userService = $userService;
        $this->friendService = $friendService;
    }

    public function compose(View $view)
    {
        $request = request();
        $user = $view->getData()['user']
            ?? $request->attributes->get('profileUser')?->loadMissing('profile')->toArray()
            ?? $this->userService->getMessageUser($request->route('username'));

        $currentUserId = Auth::id();

        $currentUserProfile = $user['id'] === $currentUserId;

        $friendRequestCount = $currentUserProfile
            ? $this->friendService->getFriendsCount($currentUserId)
            : 0;
        $view->with('user', $user)
            ->with('currentUserProfile', $currentUserProfile)
            ->with('friendRequestCount', $friendRequestCount)
            ->with('unreadMessageCount', $currentUserProfile ? $this->messageService->getUnreadCount($currentUserId) : 0)
            ->with('dueMaintenanceCount', $currentUserProfile
                ? ($view->getData()['dueMaintenanceCount'] ?? MaintenanceReminder::forOwner($currentUserId)->due()->count())
                : 0);
    }
}
