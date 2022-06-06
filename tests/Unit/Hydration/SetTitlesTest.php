<?php declare(strict_types=1);

namespace Tests\Unit\Hydration;

use Dive\Fez\Hydration\SetTitles;
use Dive\Fez\MetaData;
use Illuminate\Contracts\Config\Repository;
use Mockery;
use Tests\Fakes\RickRollFormatter;

test('set title task', function () {
    $task = new SetTitles($config = Mockery::mock(Repository::class), $fez = createFez());
    $config->shouldReceive('get')
        ->once()
        ->with('fez.title')
        ->andReturn(RickRollFormatter::class);

    expect($fez->roll->title)->toBeNull();

    $task->handle(MetaData::make(title: 'Pest'), fn ($data) => $data);

    expect(
        $fez->roll->title->value()
    )->toBe('Never Gonna Give You Up, Pest!');
});
