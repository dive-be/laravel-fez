<?php declare(strict_types=1);

namespace Tests\Unit\Hydration;

use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Hydration\SetTitles;
use Tests\Fakes\RickRollFormatter;

test('set title task', function () {
    $task = new SetTitles($fez = createFez(['title' => RickRollFormatter::class]));

    expect($fez->roll->title)->toBeNull();

    $task->handle(MetaData::make(title: 'Pest'), fn ($data) => $data);

    expect(
        $fez->roll->title->value()
    )->toBe('Never Gonna Give You Up, Pest!');
});
