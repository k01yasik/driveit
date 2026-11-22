// app/Policies/FriendPolicy.php
<?php

namespace App\Policies;

use App\Friend;
use App\User;

class FriendPolicy
{
    public function accept(User $user, Friend $friend): bool
    {
        return $friend->friend_id === $user->id && !$friend->confirmed;
    }

    public function cancel(User $user, Friend $friend): bool
    {
        return ($friend->user_id === $user->id || $friend->friend_id === $user->id) && !$friend->confirmed;
    }
}
