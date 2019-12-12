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
     * @param int $authUser
     * @param string $friend
     */
    public function store(int $authUser, string $friend): void;
}