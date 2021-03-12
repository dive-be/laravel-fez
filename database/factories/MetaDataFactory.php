<?php

namespace Dive\Fez\Database\Factories;

use Dive\Fez\Models\MetaData;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetaDataFactory extends Factory
{
    protected $model = MetaData::class;

    public function definition()
    {
        return [
            'description' => $this->faker->text(255),
            'image' => 'https://picsum.photos/1200/627',
            'keywords' => $this->faker->words,
            'robots' => 'all',
            'title' => $this->faker->title,
        ];
    }
}
