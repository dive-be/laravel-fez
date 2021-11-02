<?php declare(strict_types=1);

namespace Tests\Unit\Hydration;

use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Hydration\SetImages;

test('set descriptions task', function () {
    $task = new SetImages($fez = createFez());

    expect($fez->roll->image)->toBeNull();

    $task->handle(MetaData::make(image: '/static/assets/img/rick_astley.jpg'), fn ($data) => $data);

    expect(
        $fez->roll->image->value()
    )->toBe('/static/assets/img/rick_astley.jpg');
});
