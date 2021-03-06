<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Seo;
use Faker\Generator as Faker;

$factory->define(Seo::class, function (Faker $faker) {
    return [
        'route_name' => $faker->word.$faker->word,
        'title' => $faker->sentence(5, true),
        'description' => $faker->sentence(10, true)
    ];
});
