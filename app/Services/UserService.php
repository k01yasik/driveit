<?php

namespace App\Services;


use App\Repositories\CachedUserRepository;
use App\Repositories\Interfaces\RipRepositoryInterface;

class UserService
{
    private CachedUserRepository $userRepository;
    private RipRepositoryInterface $ripRepository;

    public function __construct(CachedUserRepository $userRepository, RipRepositoryInterface $ripRepository)
    {
        $this->userRepository = $userRepository;
        $this->ripRepository = $ripRepository;
    }

    public function getCurrentUserWithProfile(int $id): array
    {
        return $this->userRepository->getCurrentUserWithProfile($id);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->getAllUsers();
    }

    public function getAllUnbannedUsers(): array
    {
        $ripIds = [];

        $rips = $this->ripRepository->getAll();

        foreach ($rips as $rip) {
            $ripIds[] = $rip['user_id'];
        }

        return $this->userRepository->getAllUnbannedUsers($ripIds);
    }

    public function getVerifiedUsers(): array
    {
        return $this->userRepository->getVerifiedUsers();
    }

    public function getUnverifiedUsers(): array
    {
        return $this->userRepository->getUnverifiedUsers();
    }

    public function getBannedUsers(): array
    {
        $ripIds = [];

        $rips = $this->ripRepository->getAll();

        foreach ($rips as $rip) {
            $ripIds[] = $rip['user_id'];
        }

        return $this->userRepository->getBannedUsers($ripIds);
    }

    public function getUserByUsername(string $username): array
    {
        return $this->userRepository->getUserByUsername($username);
    }

    public function getMessageUser(string $username): array
    {
        return $this->userRepository->getMessageUser($username);
    }

    public function getAllPublicUsers(int $id): array
    {
        return $this->userRepository->getAllPublicUsers($id);
    }

    public function getUsersWithFriends(int $id): array
    {
        return $this->userRepository->getUsersWithFriends($id);
    }

    public function getUserForAlbums(string $username): array
    {
        return $this->userRepository->getUserForAlbums($username);
    }
}