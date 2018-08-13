<?php

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
        'image' => '/photo/repair-of-car-dents.jpg',
        'caption' => $faker->paragraph(7),
        'body' => $faker->text(3000),
        'text' => function (array $post) {
            return $post['caption'] . ' ' . $post['body'];
        },
        'user_id' => function () {
            return User::find(1)->id;
        },
        'rating' => $faker->numberBetween(0, 1000),
        'views' => $faker->numberBetween(1, 1000),
        'comments' => $faker->numberBetween(1, 200)
    ];
});
