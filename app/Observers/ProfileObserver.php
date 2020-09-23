<?php

namespace App\Observers;

use App\Profile;
use Illuminate\Support\Facades\Cache;

class ProfileObserver
{
    /**
     * Handle the profile "created" event.
     *
     * @param  \App\Profile  $profile
     * @return void
     */
    public function created(Profile $profile)
    {
        //
    }

    /**
     * Handle the profile "updated" event.
     *
     * @param  \App\Profile  $profile
     * @return void
     */
    public function updated(Profile $profile)
    {
        //
    }

    /**
     * @param \App\Profile $profile
     * @return void
     */
    public function saved(Profile $profile)
    {
        Cache::forget('latest-posts');
        Cache::forget('all-users');
        Cache::forget('all-public-users');
    }

    /**
     * Handle the profile "deleted" event.
     *
     * @param  \App\Profile  $profile
     * @return void
     */
    public function deleted(Profile $profile)
    {
        //
    }

    /**
     * Handle the profile "restored" event.
     *
     * @param  \App\Profile  $profile
     * @return void
     */
    public function restored(Profile $profile)
    {
        //
    }

    /**
     * Handle the profile "force deleted" event.
     *
     * @param  \App\Profile  $profile
     * @return void
     */
    public function forceDeleted(Profile $profile)
    {
        //
    }
}
