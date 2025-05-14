<?php

namespace App\Services;

use App\Repositories\Interfaces\FriendRepositoryInterface;
use Illuminate\Support\Collection;

class FriendService
{
    public function __construct(
        private FriendRepositoryInterface $friendRepository
    ) {
    }

    public function getConfirmedFriendsIds(Collection $friends): array
    {
        return $friends
            ->where('confirmed', true)
            ->pluck('friend_id')
            ->toArray();
    }

    public function getRequestedFriendsIds(Collection $friends): array
    {
        return $friends->pluck('friend_id')->toArray();
    }

    public function getFriendsCount(int $userId): int
    {
        return $this->friendRepository->getPendingRequestsCount($userId);
    }

    public function sendFriendRequest(int $senderId, int $recipientId): void
    {
        $this->friendRepository->createFriendRequest($senderId, $recipientId, true);
        $this->friendRepository->createFriendRequest($recipientId, $senderId, false);
    }

    public function getPendingRequests(int $userId): Collection
    {
        return $this->friendRepository->getPendingRequests($userId);
    }

    public function getFriends(int $userId): Collection
    {
        return $this->friendRepository->getFriends($userId);
    }

    public function acceptFriendRequest(int $requestId, int $currentUserId): void
    {
        $this->friendRepository->confirmFriendRequest($requestId, $currentUserId);
        $this->friendRepository->confirmFriendRequest($currentUserId, $requestId);
    }
}
