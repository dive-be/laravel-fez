<?php declare(strict_types=1);

namespace Tests\Unit\Hydration;

use Dive\Fez\Hydration\SetDescriptions;
use Dive\Fez\MetaData;

test('set descriptions task', function () {
    $task = new SetDescriptions($fez = createFez());

    expect($fez->roll->description)->toBeNull();

    $task->handle(MetaData::make(description: 'Never Gonna Give You Up'), fn ($data) => $data);

    expect(
        $fez->roll->description->value()
    )->toBe('Never Gonna Give You Up');
});
