<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 25.04.2019
 * Time: 18:58
 */

namespace App\Services;

use App\Advertisement;

class AdvertisementService
{
    public function getAds()
    {
        $adverts_elements = [];

        $adverts_count = Advertisement::all()->count();

        for ($i = 1; $i < 4; $i++) {
            array_push($adverts_elements, random_int(1, $adverts_count));
        }

        return Advertisement::find($adverts_elements);
    }
}