<?php

namespace App\Repositories;

use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Friend;

class FriendRepository implements FriendRepositoryInterface
{

    /**
     * @param int $id
     * @return int
     */
    public function getFriendsCount(int $id): int
    {
        return Friend::where([['friend_id', $id], ['confirmed', 0], ['owner', 1]])->get()->count();
    }

    /**
     * @param int $authUser
     * @param string $friend
     */
    public function store(int $authUser, string $friend): void
    {
        $friend_db = new Friend;
        $friend_db->user_id = $authUser;
        $friend_db->friend_id = $friend;
        $friend_db->owner = true;
        $friend_db->save();

        $friend_db = new Friend;
        $friend_db->user_id = $friend;
        $friend_db->friend_id = $authUser;
        $friend_db->owner = false;
        $friend_db->save();
    }
}