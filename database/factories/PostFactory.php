<?php

namespace Database\Factories;

use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $faker = $this->faker;
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
            'user_id' => User::factory(),
            'views' => $faker->numberBetween(1, 1000),
        ];
    }
}
