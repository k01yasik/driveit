<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::find(1)->id;
        },
        'avatar' => '/photo/admin-avatar.jpg',
        'public' => true
    ];
});
