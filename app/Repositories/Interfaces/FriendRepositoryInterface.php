<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface FriendRepositoryInterface
{
    public function getPendingRequestsCount(int $userId): int;
    public function createFriendRequest(int $userId, int $friendId, bool $isOwner): void;
    public function getPendingRequests(int $userId): Collection;
    public function getFriends(int $userId): Collection;
    public function confirmFriendRequest(int $userId, int $friendId): void;
}
