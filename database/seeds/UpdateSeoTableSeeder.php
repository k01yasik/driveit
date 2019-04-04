<?php

use Illuminate\Database\Seeder;
use App\Seo;

class UpdateSeoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Seo::where('route_name', 'goods.index')->delete();
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }

        $seo = new Seo;
        $seo->route_name = 'store.index';
        $seo->title = 'Автомобильные интернет-магазины';
        $seo->description = 'Найдите и купите самые лучшие автомобильные товары';
        $seo->save();
    }
}
