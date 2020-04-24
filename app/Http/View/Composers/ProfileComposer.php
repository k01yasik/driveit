<?php


namespace App\Http\View\Composers;

use App\Repositories\CachedUserRepository;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileComposer
{
    protected $userRepository;
    protected $friendRepository;

    public function __construct(CachedUserRepository $userRepository,
                                FriendRepositoryInterface $friendRepository)
    {
        $this->userRepository = $userRepository;
        $this->friendRepository = $friendRepository;
    }

    public function compose(View $view)
    {
        $user = $this->userRepository
            ->getMessageUser(request()->route()->parameter('username'));

        $currentUserId = Auth::id();

        $currentUserProfile = $user->id === $currentUserId;

        $friendRequestCount = $this->friendRepository
            ->getFriendsCount($currentUserId);
        $view->with('user', $user)
            ->with('currentUserProfile', $currentUserProfile)
            ->with('friendRequestCount', $friendRequestCount);
    }
}
