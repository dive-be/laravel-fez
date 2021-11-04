<?php declare(strict_types=1);

namespace Tests\Unit\Hydration;

use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Feature;
use Dive\Fez\Hydration\AssignOpenGraphProperties;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\OpenGraph\Properties\Audio;

test('assign open graph properties task', function () {
    $fez = createFez([Feature::openGraph() => Website::make()]);
    $task = new AssignOpenGraphProperties($fez);
    $object = Website::make()
        ->title('Rick Astley')
        ->description('Never Gonna Give You Up')
        ->image('/static/assets/img/rick_astley.jpg')
        ->audio(Audio::make()->secureUrl('https://soundcloud.com'))
        ->toArray();

    expect($fez->openGraph)->toHaveCount(1);

    $task->handle(MetaData::make(open_graph: $object), fn ($data) => $data);

    expect($fez->openGraph->toArray())->toMatchArray($object);
});
