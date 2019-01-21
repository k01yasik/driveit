<?php

namespace App\Observers;

use App\Rip;
use Illuminate\Support\Facades\Cache;

class RipObserver
{
    /**
     * Handle the rip "created" event.
     *
     * @param  \App\Rip  $rip
     * @return void
     */
    public function created(Rip $rip)
    {
        Cache::forget('all-users');
    }

    /**
     * Handle the rip "updated" event.
     *
     * @param  \App\Rip  $rip
     * @return void
     */
    public function updated(Rip $rip)
    {
        //
    }

    /**
     * Handle the rip "deleted" event.
     *
     * @param  \App\Rip  $rip
     * @return void
     */
    public function deleted(Rip $rip)
    {
        Cache::forget('all-users');
    }

    /**
     * Handle the rip "restored" event.
     *
     * @param  \App\Rip  $rip
     * @return void
     */
    public function restored(Rip $rip)
    {
        //
    }

    /**
     * Handle the rip "force deleted" event.
     *
     * @param  \App\Rip  $rip
     * @return void
     */
    public function forceDeleted(Rip $rip)
    {
        //
    }
}
