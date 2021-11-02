<?php declare(strict_types=1);

namespace Tests\Unit\Factories\Feature;

use Dive\Fez\Factories\Feature\TwitterCardsFactory;
use Dive\Fez\TwitterCards\Cards\Summary;

it('can create a preconfigured card instance', function () {
    $factory = TwitterCardsFactory::make();

    $card = $factory->create([
        'description' => 'Never Gonna Give You Up',
        'image' => '/static/assets/rick_astley.jpg',
        'site' => '@mabdullahsari',
        'type' => 'summary',
    ]);

    expect($card)
        ->toBeInstanceOf(Summary::class)
        ->toHaveCount(4)
        ->card->content()->toBe('summary')
        ->description->content()->toBe('Never Gonna Give You Up')
        ->image->content()->toBe('/static/assets/rick_astley.jpg')
        ->site->content()->toBe('@mabdullahsari');
});
