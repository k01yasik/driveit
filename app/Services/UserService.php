<?php

namespace App\Services;


use App\Repositories\CachedUserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    private $userRepository;

    public function __construct(CachedUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCurrentUserWithProfile(int $id)
    {
        return $this->userRepository->getCurrentUserWithProfile($id);
    }

    /**
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAllUsers();
    }

    public function getAllUnbannedUsers(): Collection
    {
        return $this->userRepository->getAllUnbannedUsers();
    }

    public function getVerifiedUsers(): Collection
    {
        return $this->userRepository->getVerifiedUsers();
    }

    public function getUnverifiedUsers(): Collection
    {
        return $this->userRepository->getUnverifiedUsers();
    }

    public function getBannedUsers(): Collection
    {
        return $this->userRepository->getBannedUsers();
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getUserByUsername(string $username): Model
    {
        return $this->userRepository->getUserByUsername($username);
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getMessageUser(string $username): Model
    {
        return $this->userRepository->getMessageUser($username);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getAllPublicUsers(int $id): Collection
    {
        return $this->userRepository->getAllPublicUsers($id);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getUsersWithFriends(int $id): Model
    {
        return $this->userRepository->getUsersWithFriends($id);
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getUserForAlbums(string $username): Model
    {
        return $this->userRepository->getUserForAlbums($username);
    }
}