<?php declare(strict_types=1);

namespace Tests\Fakes\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Fakes\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'author' => $this->faker->firstName(),
            'body' => $this->faker->realText(),
            'hero' => 'https://picsum.photos/seed/picsum/1200/630',
            'title' => $this->faker->title(),
            'short_description' => $this->faker->text(100),
        ];
    }
}
