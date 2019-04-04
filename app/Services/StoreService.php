<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 07.03.2019
 * Time: 0:30
 */

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Store;

class StoreService
{
    public function getStores() {

        $stores = Cache::rememberForever('all-stores', function () {
            return Store::all();
        });

        return $stores;
    }
}