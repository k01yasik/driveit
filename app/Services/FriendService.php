<?php

namespace App\Services;

use App\Repositories\Interfaces\FriendRepositoryInterface;
use Illuminate\Support\Collection;

class FriendService implements Interfaces\FriendServiceInterface
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

    public function sendFriendRequest(int $senderId, int $recipientId): bool
    {
        return $this->friendRepository->createFriendRequest($senderId, $recipientId);
    }

    public function getPendingRequests(int $userId): Collection
    {
        return $this->friendRepository->getPendingRequests($userId);
    }

    public function getFriends(int $userId): Collection
    {
        return $this->friendRepository->getFriends($userId);
    }

    public function getOutgoingRequests(int $userId): Collection
    {
        return $this->friendRepository->getOutgoingRequests($userId);
    }

    public function dismissRequest(int $userId, int $otherId, bool $outgoing): void
    {
        $this->friendRepository->dismissRequest($userId, $otherId, $outgoing);
    }

    public function removeFriend(int $userId, int $friendId): void
    {
        $this->friendRepository->removeFriend($userId, $friendId);
    }

    public function areFriends(int $userId, int $friendId): bool
    {
        return $this->friendRepository->areFriends($userId, $friendId);
    }

    public function acceptFriendRequest(int $requestId, int $currentUserId): bool
    {
        return $this->friendRepository->confirmFriendRequest($requestId, $currentUserId);
    }
}
