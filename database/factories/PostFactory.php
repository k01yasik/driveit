<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'slug' => $faker->slug,
        'title' => $faker->sentence(8),
        'description' => $faker->paragraph(3),
        'name' => function (array $post) {
            return $post['title'];
        },
        'image_path' => '/photo/repair-of-car-dents.jpg',
        'is_published' => true,
        'caption' => $faker->paragraph(7),
        'body' => $faker->text(3000),
        'user_id' => factory(User::class),
        'views' => $faker->numberBetween(1, 1000),
    ];
});
