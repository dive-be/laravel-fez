<?php declare(strict_types=1);

namespace Tests\Unit\Hydration;

use Dive\Fez\Feature;
use Dive\Fez\Hydration\AssignTwitterProperties;
use Dive\Fez\MetaData;
use Dive\Fez\TwitterCards\Cards\Summary;

test('assign twitter properties task', function () {
    $fez = createFez([Feature::twitterCards() => Summary::make()]);
    $task = new AssignTwitterProperties($fez);
    $card = Summary::make()
        ->title('Rick Astley')
        ->description('Never Gonna Give You Up')
        ->image('/static/assets/img/rick_astley.jpg')
        ->toArray();

    expect($fez->twitterCards)->toHaveCount(1);

    $task->handle(MetaData::make(twitter: $card), fn ($data) => $data);

    expect($fez->twitterCards->toArray())->toMatchArray($card);
});
