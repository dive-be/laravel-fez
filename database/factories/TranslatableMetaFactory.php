<?php

namespace Dive\Fez\Database\Factories;

use Dive\Fez\Models\TranslatableMeta;

class TranslatableMetaFactory extends MetaFactory
{
    protected $model = TranslatableMeta::class;

    public function definition(): array
    {
        return array_merge(parent::definition(), [
            'description' => [app()->getLocale() => $this->faker->text(255)],
            'title' => [app()->getLocale() => $this->faker->title],
        ]);
    }
}
