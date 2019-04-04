<?php

use Illuminate\Database\Seeder;
use LireinCore\YMLParser\YML;
use App\SshinaCategory;
use App\Sshina;

class SshinaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $yml = new YML();

        try {
            $yml->parse(storage_path('app/admitad/sshina.yml'));
            $shop = $yml->getShop();

            if ($shop->isValid()) {

                $offersCount = $shop->getOffersCount();
                \Log::info($offersCount);
                $shopData = $shop->getData();

                foreach ($shopData['categories'] as $category) {
                    $table_sshina = new SshinaCategory;
                    $table_sshina->category_id = $category['id'];
                    if (isset($category['parentId'])) {
                        $table_sshina->parent_id = $category['parentId'];
                    }
                    $table_sshina->name = $category['name'];
                    $table_sshina->save();
                }

                foreach ($yml->getOffers() as $offer) {

                    if ($offer->isValid()) {
                        $offerData = $offer->getData();

                        $table_entry = new Sshina;
                        $table_entry->name = $offerData['name'];
                        $table_entry->vendor = $offerData['vendor'];
                        $table_entry->offer_id = $offerData['id'];
                        $table_entry->url = $offerData['url'];
                        $table_entry->price = $offerData['price'];
                        $table_entry->currency_id = $offerData['currencyId'];
                        $table_entry->category_id = $offerData['categoryId'];
                        if (isset($offerData['pictures'])) {
                            $table_entry->picture = str_replace('http:', 'https:', $offerData['pictures'][0]);
                        } else {
                            $table_entry->picture = 'https://www.s-shina.ru/images/disk/series/nophotodisk.jpg';
                        }
                        $table_entry->save();


                    } else {
                        \Log::info(print_r($offer->getErrors(), true));
                    }
                }

            } else {
                \Log::info(print_r($shop->getErrors(), true));
            }

        } catch (\Exception $e) {
            \Log::info(print_r($e->getMessage(), true));
        }

    }
}
