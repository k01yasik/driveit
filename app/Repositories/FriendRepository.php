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
     * @param int $authUserId
     * @param int $friend
     * @param bool $owner
     */
    public function add(int $authUserId, int $friend, bool $owner): void
    {
        $friend_db = new Friend;
        $friend_db->user_id = $authUserId;
        $friend_db->friend_id = $friend;
        $friend_db->owner = $owner;
        $friend_db->save();
    }

    public function getFriendsRequests(int $friendId): array
    {
        return Friend::with(['user', 'user.profile'])->where([['friend_id', $friendId], ['confirmed', 0], ['owner', 1]])->get()->toArray();
    }

    public function getFriendsList(int $friendId): array
    {
        return Friend::with(['user', 'user.profile'])->where([['friend_id', $friendId], ['confirmed', 1]])->get()->toArray();
    }

    public function confirmUsers(int $id, int $currentUserId): void
    {
        $friend = Friend::where([['user_id', $id], ['friend_id', $currentUserId]])->first();
        $friend->confirmed = true;
        $friend->save();
    }
}