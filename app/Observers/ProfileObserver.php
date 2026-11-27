<?php

namespace App\Observers;

use App\Profile;
use App\Repositories\CachedPostRepository;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;

class ProfileObserver implements ShouldHandleEventsAfterCommit
{
    public function saved(Profile $profile): void
    {
        foreach ([
            'user_with_profile_'.$profile->user_id,
            'all-users',
            'unbanned-users',
            'verified-users',
            'unverified-users',
            'banned-users',
            'latest-posts',
        ] as $key) {
            Cache::forget($key);
        }

        CachedPostRepository::invalidateListings();
    }

    public function deleted(Profile $profile): void
    {
        $this->saved($profile);
    }
}
