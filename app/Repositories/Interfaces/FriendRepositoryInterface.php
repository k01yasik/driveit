<?php

namespace App\Repositories\Interfaces;

interface FriendRepositoryInterface
{
    /**
     * @param int $id
     * @return int
     */
    public function getFriendsCount(int $id): int;

    /**
     * @param int $authUserId
     * @param int $friend
     * @param bool $owner
     */
    public function add(int $authUserId, int $friend, bool $owner): void;

    public function getFriendsRequests(int $friendId): array;

    public function getFriendsList(int $friendId): array;

    public function confirmUsers(int $id, int $currentUserId): void;
}