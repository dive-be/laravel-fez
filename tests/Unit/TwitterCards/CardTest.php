<?php declare(strict_types=1);

namespace Tests\Unit\TwitterCards;

use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\TwitterCards\Cards\Summary;
use Dive\Fez\TwitterCards\Property;

beforeEach(function () {
    $this->card = Summary::make(); // Summary is 1-to-1 equal to a Card without any additional behavior
});

it('is arrayable', function () {
    expect(
        $this->card->toArray()
    )->toMatchArray([
        'properties' => [
            [
                'attributes' => [
                    'content' => 'summary',
                    'name' => 'card',
                ],
                'type' => 'property',
            ],
        ],
        'type' => 'summary',
    ]);
});

it('is describable', function () {
    $this->card->description('Never Gonna Give You Up');

    expect($this->card)
        ->toBeInstanceOf(Describable::class)
        ->description->content()->toBe('Never Gonna Give You Up');
});

it('is imageable', function () {
    $this->card->image('/static/assets/img/rick_astley.jpg', 'Rick Astley');

    expect($this->card)
        ->toBeInstanceOf(Imageable::class)
        ->image->content()->toBe('/static/assets/img/rick_astley.jpg')
        ->{'image:alt'}->content()->toBe('Rick Astley');
});

it('is titleable', function () {
    $this->card->title('Rick Astley');

    expect($this->card)
        ->toBeInstanceOf(Titleable::class)
        ->title->content()->toBe('Rick Astley');
});

it('can set site', function () {
    expect(
        $this->card->site('@dive')
    )->site->content()->toBe('@dive');
});

it('can get the type', function () {
    expect($this->card->type())->toBe('summary');
});

it('can set a property', function () {
    $this->card->setProperty('rick', 'astley');

    expect($this->card->get('rick'))
        ->toBeInstanceOf(Property::class)
        ->content()->toBe('astley');
});
