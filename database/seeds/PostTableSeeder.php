<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 10)->create();

        factory(App\Post::class, 100)
            ->create()
            ->each(function ($u) {
                $u->categories()->attach([random_int(1, 10), random_int(1, 10)]);
            });

    }
}
