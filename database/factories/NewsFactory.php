<?php

namespace Database\Factories;

use App\News;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'slug' => $faker->slug,
            'title' => $faker->sentence(8),
            'description' => $faker->paragraph(3),
            'name' => function (array $news) {
                return $news['title'];
            },
            'caption' => $faker->paragraph(7),
            'body' => $faker->text(1500),
            'image_path' => $faker->imageUrl(500, 333),
            'is_published' => true,
            'date_published' => $faker->dateTimeThisMonth('now', 'Europe/Moscow'),
            'user_id' => function (array $news) {
                return User::where('username', 'Bzdykin')->firstOrFail()->id;
            },
            'views' => $faker->numberBetween(1, 1000)
        ];
    }
}
