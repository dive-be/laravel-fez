<?php

namespace Dive\Fez\Database\Factories;

use Dive\Fez\Models\StaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaticPageFactory extends Factory
{
    protected $model = StaticPage::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(255),
            'key' => $this->faker->unique()->word,
            'name' => $this->faker->text(20),
        ];
    }
}
