<?php

namespace Dive\Fez\Database\Factories;

use Dive\Fez\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    protected $model = Route::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(255),
            'key' => $this->faker->unique()->word,
            'name' => $this->faker->text(20),
        ];
    }
}
