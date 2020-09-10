<?php

namespace App\Repositories;

use App\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\User;

class ProfileRepository implements ProfileRepositoryInterface
{

    public function add(int $userId, string $avatarUrl): void
    {
        $profile = User::find($userId)->profile()->firstOrFail();
        $profile->avatar = $avatarUrl;
        $profile->save();
    }
}