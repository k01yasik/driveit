<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 18.08.2018
 * Time: 17:24
 */

namespace App\Services;

use App\Repositories\Interfaces\FriendRepositoryInterface;

class FriendService
{
    private $friendRepository;

    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function getConfirmedFriends($friends)
    {
        $friendsId = [];

        foreach ($friends as $friend) {
            if ($friend->confirmed) {
                array_push($friendsId, $friend->friend_id);
            }
        }

        return $friendsId;
    }

    public function getRequestedFriends($friends)
    {
        $friendsId = [];

        foreach ($friends as $friend)
        {
            array_push($friendsId, $friend->friend_id);
        }

        return $friendsId;
    }

    public function getFriendsCount(int $id): int
    {
        return $this->friendRepository->getFriendsCount($id);
    }

    public function addFriend(int $authUserId, int $friend): void
    {
        $this->friendRepository->add($authUserId, $friend, true);
        $this->friendRepository->add($friend, $authUserId, false);
    }

    public function getFriendsRequests(int $friendId): array
    {
        return $this->friendRepository->getFriendsRequests($friendId);
    }

    public function getFriendsList(int $friendId): array
    {
        return $this->friendRepository->getFriendsList($friendId);
    }

    public function confirmUsers(int $id, int $currentUserId): void
    {
        $this->friendRepository->confirmUsers($id, $currentUserId);
        $this->friendRepository->confirmUsers($currentUserId, $id);
    }
}