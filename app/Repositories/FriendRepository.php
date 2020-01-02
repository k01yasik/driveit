<?php

namespace App\Repositories;

use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Friend;
use Illuminate\Database\Eloquent\Collection;

class FriendRepository implements FriendRepositoryInterface
{

    /**
     * @param int $id
     * @return int
     */
    public function getFriendsCount(int $id): int
    {
        return Friend::where([['friend_id', $id], ['confirmed', 0], ['owner', 1]])->count();
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

    /**
     * @param int $id
     * @return int
     */
    public function getFriendsCountToUserAlbums(int $id): int
    {
        return Friend::where([['friend_id', $id], ['confirmed', 0]])->count();
    }

    public function getFriendsRequests(int $friend_id): Collection
    {
        return Friend::with(['user', 'user.profile'])->where([['friend_id', $friend_id], ['confirmed', 0], ['owner', 1]])->get();
    }

    public function getFriendsList(int $friend_id): Collection
    {
        return Friend::with(['user', 'user.profile'])->where([['friend_id', $friend_id], ['confirmed', 1]])->get();
    }

    public function confirmUsers(int $id, int $current_id): void
    {
        $friend = Friend::where([['user_id', $id], ['friend_id', $current_id]])->firstOrFail();
        $friend->confirmed = true;
        $friend->save();

        $friend = Friend::where([['user_id', $current_id], ['friend_id', $id]])->firstOrFail();
        $friend->confirmed = true;
        $friend->save();
    }
}