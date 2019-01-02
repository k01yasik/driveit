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
        $seo = new Seo;
        $seo->route_name = 'admin.posts.html';
        $seo->title = 'Редактирование HTML статьи';
        $seo->description = 'Редактирование HTML статьи';
        $seo->save();
    }
}
