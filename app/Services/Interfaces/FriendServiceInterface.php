// app/Services/Interfaces/FriendServiceInterface.php
<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface FriendServiceInterface
{
    public function getConfirmedFriendsIds(Collection $friends): array;
    public function getRequestedFriendsIds(Collection $friends): array;
    public function getFriendsCount(int $userId): int;
    public function sendFriendRequest(int $senderId, int $recipientId): void;
    public function getPendingRequests(int $userId): Collection;
    public function getFriends(int $userId): Collection;
    public function acceptFriendRequest(int $requestId, int $currentUserId): void;
}
