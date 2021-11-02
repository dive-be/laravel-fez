<?php declare(strict_types=1);

namespace Dive\Fez\Database\Factories;

use Dive\Fez\Models\Meta;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetaFactory extends Factory
{
    protected $model = Meta::class;

    public function definition(): array
    {
        return [];
    }

    public function withDescription(): self
    {
        return $this->state([
            'description' => $this->faker->text(255),
        ]);
    }

    public function withImage(): self
    {
        return $this->state([
            'image' => 'https://picsum.photos/1200/627',
        ]);
    }

    public function withTitle(): self
    {
        return $this->state([
            'title' => $this->faker->title,
        ]);
    }
}
