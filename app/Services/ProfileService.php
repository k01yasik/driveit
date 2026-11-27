<?php

namespace App\Services;

use App\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\User;
use Illuminate\Support\Arr;

class ProfileService
{
    public function __construct(private readonly ProfileRepositoryInterface $profileRepository)
    {
    }

    public function initialize(User $user, ?string $avatarUrl = null): Profile
    {
        $avatarUrl = $avatarUrl ?: rtrim(config('app.url'), '/').'/storage/avatars/user.svg';

        return $this->profileRepository->initialize($user, $avatarUrl);
    }

    public function addUserAvatar(int $userId, string $avatarUrl): void
    {
        $this->profileRepository->update($userId, ['avatar' => $avatarUrl]);
    }

    public function updateVisibility(int $userId, bool $public): void
    {
        $this->profileRepository->update($userId, ['public' => $public]);
    }

    public function updateDetails(int $userId, array $details): void
    {
        $this->profileRepository->update($userId, Arr::only($details, ['first_name', 'last_name', 'city', 'about']));
    }
}
