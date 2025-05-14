<?php

namespace App\Repositories;

use App\Models\Friend;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FriendRepository implements FriendRepositoryInterface
{
    public function getPendingRequestsCount(int $userId): int
    {
        return Friend::pendingRequestsToUser($userId)->count();
    }

    public function createFriendRequest(int $userId, int $friendId, bool $isOwner): void
    {
        Friend::create([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'owner' => $isOwner,
            'confirmed' => false,
        ]);
    }

    public function getPendingRequests(int $userId): Collection
    {
        return Friend::with(['user', 'user.profile'])
            ->pendingRequestsToUser($userId)
            ->get();
    }

    public function getFriends(int $userId): Collection
    {
        return Friend::with(['user', 'user.profile'])
            ->confirmedFriendsOfUser($userId)
            ->get();
    }

    public function confirmFriendRequest(int $userId, int $friendId): void
    {
        Friend::where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->update(['confirmed' => true]);
    }
}
