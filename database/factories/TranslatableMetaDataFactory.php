<?php

namespace Dive\Fez\Database\Factories;

use Dive\Fez\Models\TranslatableMetaData;

class TranslatableMetaDataFactory extends MetaDataFactory
{
    protected $model = TranslatableMetaData::class;

    public function definition(): array
    {
        return array_merge(parent::definition(), [
            'description' => [app()->getLocale() => $this->faker->text(255)],
            'title' => [app()->getLocale() => $this->faker->title],
        ]);
    }
}
