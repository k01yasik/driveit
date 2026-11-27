<?php

namespace App\Repositories;

use App\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\User;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function initialize(User $user, string $avatarUrl): Profile
    {
        return $user->profile()->firstOrCreate([], ['avatar' => $avatarUrl, 'public' => false]);
    }

    public function update(int $userId, array $attributes): void
    {
        $profile = Profile::where('user_id', $userId)->firstOrFail();
        $profile->fill($attributes);

        if ($profile->isDirty()) {
            $profile->save();
        }
    }
}
