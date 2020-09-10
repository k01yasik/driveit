<?php

namespace App\Services;


use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileService
{
    /**
     * @var ProfileRepositoryInterface
     */
    private ProfileRepositoryInterface $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function addUserAvatar(int $userId, string $avatarUrl): void
    {
        $this->profileRepository->add($userId, $avatarUrl);
    }
}