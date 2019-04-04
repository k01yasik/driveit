<?php

use Illuminate\Database\Seeder;
use App\Store;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = new Store;
        $store->name = 's-shina';
        $store->table_name = 'sshinas';
        $store->url = 'http://www.s-shina.ru/';
        $store->logo = 'https://www.s-shina.ru/templates/aqua/images/s-shina-logo.jpg';
        $store->save();
    }
}
