<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(App\Category::class, 10)->create();

        factory(App\Post::class, 100)
            ->create()
            ->each(function ($u) {
                $u->categories()->attach([random_int(1, 10), random_int(1, 10)]);
            });*/

        $category = new Category;
        $category->name = 'auto';
        $category->displayname = 'авто';
        $category->save();

        $category = new Category;
        $category->name = 'auto-reviews';
        $category->displayname = 'обзоры автомобилей';
        $category->save();

        $category = new Category;
        $category->name = 'auto-repairs';
        $category->displayname = 'ремонт автомобиля';
        $category->save();

        $category = new Category;
        $category->name = 'car-care';
        $category->displayname = 'уход за автомобилем';
        $category->save();

        $category = new Category;
        $category->name = 'car-device';
        $category->displayname = 'устройство автомобиля';
        $category->save();

        $category = new Category;
        $category->name = 'auto-tips-for-begining';
        $category->displayname = 'советы начинающим';
        $category->save();

        $category = new Category;
        $category->name = 'moto';
        $category->displayname = 'мото';
        $category->save();

        $category = new Category;
        $category->name = 'moto-reviews';
        $category->displayname = 'обзоры мотоциклов';
        $category->save();

        $category = new Category;
        $category->name = 'moto-repairs';
        $category->displayname = 'ремонт мотоцикла';
        $category->save();

        $category = new Category;
        $category->name = 'moto-care';
        $category->displayname = 'уход за мотоциклом';
        $category->save();

        $category = new Category;
        $category->name = 'law';
        $category->displayname = 'право';
        $category->save();

        $category = new Category;
        $category->name = 'helpful';
        $category->displayname = 'полезное';
        $category->save();

    }
}
