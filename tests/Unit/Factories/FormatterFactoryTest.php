<?php declare(strict_types=1);

namespace Tests\Unit\Factories;

use Dive\Fez\Factories\FormatterFactory;
use Dive\Fez\Formatters\DefaultFormatter;
use Dive\Fez\Formatters\NullFormatter;
use Tests\Fakes\RickRollFormatter;

it('creates the correct formatter for the given configuration', function (array|string|null $config, string $class) {
    expect(
        FormatterFactory::make()->create($config)
    )->toBeInstanceOf($class);
})->with([
    [RickRollFormatter::class, RickRollFormatter::class],
    [['suffix' => 'Dive', 'separator' => '~'], DefaultFormatter::class],
    [null, NullFormatter::class],
    [FormatterFactory::class, NullFormatter::class],
]);
