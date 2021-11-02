<?php declare(strict_types=1);

namespace Tests\Unit\Hydration;

use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Feature;
use Dive\Fez\Hydration\AssignMetaProperties;
use Dive\Fez\MetaElements;

test('assign meta properties task', function () {
    $fez = createFez(features: [Feature::metaElements() => MetaElements::make()]);
    $task = new AssignMetaProperties($fez);
    $elements = MetaElements::make()
        ->keywords('rick, roll')
        ->robots('index, follow')
        ->toArray();

    expect($fez->metaElements)->toHaveCount(0);

    $task->handle(MetaData::make(elements: $elements), fn ($data) => $data);

    expect($fez->metaElements->toArray())->toMatchArray($elements);
});
