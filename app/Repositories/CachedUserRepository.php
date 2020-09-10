<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;

final class CachedUserRepository implements UserRepositoryInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCurrentUserWithProfile(int $id): array
    {
        return Cache::rememberForever('user_with_profile_'.$id, function () use ($id) {
            return $this->userRepository->getCurrentUserWithProfile($id);
        });
    }

    public function getAllUsers(): array
    {
        return Cache::rememberForever('all-users', function () {
            return $this->userRepository->getAllUsers();
        });
    }

    public function getAllUnbannedUsers(array $ripIds): array
    {
        return Cache::rememberForever('unbanned-users', function () {
           return $this->userRepository->getAllUnbannedUsers();
        });
    }

    public function getVerifiedUsers(): array
    {
        return Cache::rememberForever('verified-users', function () {
           return $this->userRepository->getVerifiedUsers();
        });
    }

    public function getUnverifiedUsers(): array
    {
        return Cache::rememberForever('unverified-users', function () {
            return $this->userRepository->getUnverifiedUsers();
        });
    }

    public function getBannedUsers(array $ripIds): array
    {
        return Cache::rememberForever('banned-users', function () {
            return $this->userRepository->getBannedUsers();
        });
    }

    /**
     * @param string $username
     * @return array
     */
    public function getUserByUsername(string $username): array
    {
        return $this->userRepository->getUserByUsername($username);
    }

    /**
     * @param string $username
     * @return array
     */
    public function getMessageUser(string $username): array
    {
        return $this->userRepository->getMessageUser($username);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getAllPublicUsers(int $id): array
    {
        return Cache::rememberForever('all-public-users', function () use ($id) {
            return $this->userRepository->getAllPublicUsers($id);
        });
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUsersWithFriends(int $id): array
    {
        return $this->userRepository->getUsersWithFriends($id);
    }

    /**
     * @param string $username
     * @return array
     */
    public function getUserForAlbums(string $username): array
    {
        return $this->userRepository->getUserForAlbums($username);
    }
}