<?php

namespace Database\Factories;

use App\Seo;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeoFactory extends Factory
{
    protected $model = Seo::class;

    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'route_name' => $faker->word.$faker->word,
            'title' => $faker->sentence(5, true),
            'description' => $faker->sentence(10, true)
        ];
    }
}
