<?php declare(strict_types=1);

namespace Tests\Unit\Formatters;

use Dive\Fez\Formatters\DefaultFormatter;

it('can format using a seperator and a suffix', function (array $args, string $value, string $expected) {
    expect(
        DefaultFormatter::make(...$args)->format($value)
    )->toBe($expected);
})->with([
    [
        ['suffix' => 'Rick Astley', 'separator' => '-'],
        'Never Gonna Give You Up',
        'Never Gonna Give You Up - Rick Astley',
    ],
    [
        ['suffix' => 'DIVE', 'separator' => '|'],
        "We're digital dive-hards",
        "We're digital dive-hards | DIVE",
    ],
    [
        ['suffix' => 'Pest', 'separator' => '~'],
        '',
        'Pest',
    ],
]);
