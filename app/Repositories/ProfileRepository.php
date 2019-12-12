<?php

namespace App\Repositories;

use App\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\User;

class ProfileRepository implements ProfileRepositoryInterface
{

    public function store(User $user, string $url): Profile
    {
        $profile = $user->profile()->firstOrFail();
        $profile->avatar = $url;
        $profile->save();

        return $profile;
    }
}