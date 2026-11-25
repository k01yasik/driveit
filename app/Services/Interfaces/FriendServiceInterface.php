<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface FriendServiceInterface
{
    public function getConfirmedFriendsIds(Collection $friends): array;
    public function getRequestedFriendsIds(Collection $friends): array;
    public function getFriendsCount(int $userId): int;
    public function sendFriendRequest(int $senderId, int $recipientId): bool;
    public function getPendingRequests(int $userId): Collection;
    public function getFriends(int $userId): Collection;
    public function getOutgoingRequests(int $userId): Collection;
    public function dismissRequest(int $userId, int $otherId, bool $outgoing): void;
    public function removeFriend(int $userId, int $friendId): void;
    public function areFriends(int $userId, int $friendId): bool;
    public function acceptFriendRequest(int $requestId, int $currentUserId): bool;
}
