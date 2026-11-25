<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface FriendRepositoryInterface
{
    public function getPendingRequestsCount(int $userId): int;
    public function createFriendRequest(int $senderId, int $recipientId): bool;
    public function getPendingRequests(int $userId): Collection;
    public function getFriends(int $userId): Collection;
    public function confirmFriendRequest(int $senderId, int $recipientId): bool;
    public function getOutgoingRequests(int $userId): Collection;
    public function dismissRequest(int $userId, int $otherId, bool $outgoing): void;
    public function removeFriend(int $userId, int $friendId): void;
    public function areFriends(int $userId, int $friendId): bool;
}
