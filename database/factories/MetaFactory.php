<?php declare(strict_types=1);

namespace Dive\Fez\Database\Factories;

use Dive\Fez\Models\Meta;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetaFactory extends Factory
{
    protected $model = Meta::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(255),
            'image' => 'https://picsum.photos/1200/627',
            'title' => $this->faker->title,
        ];
    }
}
