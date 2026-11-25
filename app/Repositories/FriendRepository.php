<?php

namespace App\Repositories;

use App\Friend;
use App\User;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FriendRepository implements FriendRepositoryInterface
{
    public function getPendingRequestsCount(int $userId): int
    {
        return Friend::pendingRequestsToUser($userId)->distinct()->count('user_id');
    }

    public function createFriendRequest(int $senderId, int $recipientId): bool
    {
        return DB::transaction(function () use ($senderId, $recipientId) {
            $this->lockUsers($senderId, $recipientId);

            $existing = Friend::where('user_id', $senderId)->where('friend_id', $recipientId)->exists()
                || Friend::where('user_id', $recipientId)->where('friend_id', $senderId)->exists();
            if ($existing) {
                return false;
            }

            Friend::create(['user_id' => $senderId, 'friend_id' => $recipientId, 'owner' => true]);
            Friend::create(['user_id' => $recipientId, 'friend_id' => $senderId, 'owner' => false]);

            return true;
        }, 3);
    }

    public function getPendingRequests(int $userId): Collection
    {
        return Friend::with(['user', 'user.profile'])
            ->pendingRequestsToUser($userId)
            ->get()->unique('user_id')->values();
    }

    public function getFriends(int $userId): Collection
    {
        return Friend::with(['user', 'user.profile'])
            ->confirmedFriendsOfUser($userId)
            ->get()->unique('user_id')->values();
    }

    public function confirmFriendRequest(int $senderId, int $recipientId): bool
    {
        return DB::transaction(function () use ($senderId, $recipientId) {
            $this->lockUsers($senderId, $recipientId);

            $updated = Friend::pendingRequestsToUser($recipientId)
                ->where('user_id', $senderId)
                ->update(['confirmed' => true]);

            if ($updated === 0) {
                return false;
            }

            Friend::firstOrCreate(
                ['user_id' => $recipientId, 'friend_id' => $senderId],
                ['owner' => false, 'confirmed' => true]
            );
            Friend::where('user_id', $recipientId)->where('friend_id', $senderId)
                ->where('confirmed', false)
                ->update(['confirmed' => true]);

            return true;
        }, 3);
    }

    public function getOutgoingRequests(int $userId): Collection
    {
        return Friend::with('recipient.profile')->where('user_id', $userId)
            ->where('owner', true)->where('confirmed', false)
            ->get()->unique('friend_id')->values();
    }

    public function dismissRequest(int $userId, int $otherId, bool $outgoing): void
    {
        [$senderId, $recipientId] = $outgoing ? [$userId, $otherId] : [$otherId, $userId];

        DB::transaction(function () use ($senderId, $recipientId) {
            $this->lockUsers($senderId, $recipientId);
            $pending = Friend::pendingRequestsToUser($recipientId)->where('user_id', $senderId);

            if ($pending->delete()) {
                Friend::where('user_id', $recipientId)->where('friend_id', $senderId)
                    ->where('owner', false)->where('confirmed', false)->delete();
            }
        }, 3);
    }

    public function removeFriend(int $userId, int $friendId): void
    {
        DB::transaction(function () use ($userId, $friendId) {
            $this->lockUsers($userId, $friendId);

            if ($this->areFriends($userId, $friendId) || $this->areFriends($friendId, $userId)) {
                Friend::where(fn ($pair) => $pair->where('user_id', $userId)->where('friend_id', $friendId))
                    ->orWhere(fn ($pair) => $pair->where('user_id', $friendId)->where('friend_id', $userId))
                    ->delete();
            }
        }, 3);
    }

    public function areFriends(int $userId, int $friendId): bool
    {
        return Friend::confirmedFriendsOfUser($userId)->where('user_id', $friendId)->exists();
    }

    private function lockUsers(int $firstUserId, int $secondUserId): void
    {
        User::whereKey(min($firstUserId, $secondUserId))->lockForUpdate()->firstOrFail();
        User::whereKey(max($firstUserId, $secondUserId))->lockForUpdate()->firstOrFail();
    }
}
