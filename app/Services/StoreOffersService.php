<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 07.03.2019
 * Time: 1:17
 */

namespace App\Services;

use App\Sshina;

class StoreOffersService
{
    public function getSshinaOffers() {

        $offers = Sshina::with('category')->where([['picture', '<>', 'https://www.s-shina.ru/images/disk/series/nophotodisk.jpg'], ['category_id', 3]])->orderBy('price')->take(5)->get();

        $offers_1 = Sshina::with('category')->where([['picture', '<>', 'https://www.s-shina.ru/images/disk/series/nophotodisk.jpg'], ['category_id', 5]])->orderBy('price')->take(5)->get();

        $offers_2 = Sshina::with('category')->where([['picture', '<>', 'https://www.s-shina.ru/images/disk/series/nophotodisk.jpg'], ['category_id', 6]])->orderBy('price')->take(5)->get();

        $offers_3 = Sshina::with('category')->where([['picture', '<>', 'https://www.s-shina.ru/images/disk/series/nophotodisk.jpg'], ['category_id', 7]])->orderBy('price')->take(5)->get();

        $offers_4 = Sshina::with('category')->where([['picture', '<>', 'https://www.s-shina.ru/images/disk/series/nophotodisk.jpg'], ['category_id', 8]])->orderBy('price')->take(5)->get();

        $offers = $offers->concat($offers_1)->concat($offers_2)->concat($offers_3)->concat($offers_4);

        return $offers;
    }
}