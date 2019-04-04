<?php

namespace App\Observers;

use App\Store;
use Illuminate\Support\Facades\Cache;

class StoreObserver
{
    /**
     * Handle the store "created" event.
     *
     * @param  \App\Store  $store
     * @return void
     */
    public function created(Store $store)
    {
        Cache::forget('all-stores');
    }

    /**
     * Handle the store "updated" event.
     *
     * @param  \App\Store  $store
     * @return void
     */
    public function updated(Store $store)
    {

    }

    public function saved(Store $store)
    {
        Cache::forget('all-stores');
    }

    /**
     * Handle the store "deleted" event.
     *
     * @param  \App\Store  $store
     * @return void
     */
    public function deleted(Store $store)
    {
        Cache::forget('all-stores');
    }

    /**
     * Handle the store "restored" event.
     *
     * @param  \App\Store  $store
     * @return void
     */
    public function restored(Store $store)
    {
        //
    }

    /**
     * Handle the store "force deleted" event.
     *
     * @param  \App\Store  $store
     * @return void
     */
    public function forceDeleted(Store $store)
    {
        //
    }
}
