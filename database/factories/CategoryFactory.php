<?php

namespace Database\Factories;

use App\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'name' => $faker->slug,
            'displayname' => $faker->sentence(2),
        ];
    }
}
