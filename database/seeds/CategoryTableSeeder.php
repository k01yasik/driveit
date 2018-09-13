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

        $category = new Category; //1
        $category->name = 'auto';
        $category->displayname = 'авто';
        $category->has_child = 1;
        $category->save();

        $category1 = new Category; //2
        $category1->name = 'auto-reviews';
        $category1->displayname = 'обзоры автомобилей';
        $category1->has_child = 0;
        $category1->parent_id = $category->id;
        $category1->save();

        $category1 = new Category; //3
        $category1->name = 'auto-repairs';
        $category1->displayname = 'ремонт автомобиля';
        $category1->has_child = 0;
        $category1->parent_id = $category->id;
        $category1->save();

        $category1 = new Category; //4
        $category1->name = 'car-care';
        $category1->displayname = 'уход за автомобилем';
        $category1->has_child = 0;
        $category1->parent_id = $category->id;
        $category1->save();

        $category1 = new Category; //5
        $category1->name = 'car-device';
        $category1->displayname = 'устройство автомобиля';
        $category1->has_child = 0;
        $category1->parent_id = $category->id;
        $category1->save();

        $category1 = new Category; //6
        $category1->name = 'auto-tips-for-begining';
        $category1->displayname = 'советы начинающим';
        $category1->has_child = 0;
        $category1->parent_id = $category->id;
        $category1->save();

        $category = new Category; //7
        $category->name = 'moto';
        $category->displayname = 'мото';
        $category->has_child = 1;
        $category->save();

        $category1 = new Category; //8
        $category1->name = 'moto-reviews';
        $category1->displayname = 'обзоры мотоциклов';
        $category1->has_child = 0;
        $category1->parent_id = $category->id;
        $category1->save();

        $category1 = new Category; //9
        $category1->name = 'moto-repairs';
        $category1->displayname = 'ремонт мотоцикла';
        $category1->has_child = 0;
        $category1->parent_id = $category->id;
        $category1->save();

        $category1 = new Category; //10
        $category1->name = 'moto-care';
        $category1->displayname = 'уход за мотоциклом';
        $category1->has_child = 0;
        $category1->parent_id = $category->id;
        $category1->save();

        $category = new Category; //11
        $category->name = 'law';
        $category->displayname = 'право';
        $category->has_child = 0;
        $category->save();

        $category = new Category; //12
        $category->name = 'helpful';
        $category->displayname = 'полезное';
        $category->has_child = 0;
        $category->save();

    }
}
