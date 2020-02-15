<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FriendRepositoryInterface
{
    /**
     * @param int $id
     * @return int
     */
    public function getFriendsCount(int $id): int;

    /**
     * @param int $authUser
     * @param string $friend
     */
    public function store(int $authUser, int $friend): void;

    public function getFriendsRequests(int $friend_id): Collection;

    public function getFriendsList(int $friend_id): Collection;

    public function confirmUsers(int $id, int $current_id): void;
}