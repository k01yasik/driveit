<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        Cache::forget('all-public-users');
        Cache::forget('all-users');
        Cache::forget('unbanned-users');
        Cache::forget('banned-users');
        Cache::forget('verified-users');
        Cache::forget('unverified-users');
    }

    public function saved(User $user)
    {
        Cache::forget('all-public-users');
        Cache::forget('all-users');
        Cache::forget('unbanned-users');
        Cache::forget('banned-users');
        Cache::forget('verified-users');
        Cache::forget('unverified-users');
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
