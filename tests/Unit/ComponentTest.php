<?php declare(strict_types=1);

namespace Tests\Unit;

use Tests\Fakes\Components\RickRollComponent;

it('is arrayable', function () {
    expect(
        RickRollComponent::make()->toArray()
    )->toMatchArray([
        'type' => 'rick_roll',
        'value' => 'Never Gonna Give You Up',
    ]);
});

it('is htmlable', function () {
    expect(
        RickRollComponent::make()->toHtml()
    )->toBe('Never Gonna Give You Up');
});

it('is jsonable', function () {
    expect(
        RickRollComponent::make()->toJson()
    )->toBe('{"type":"rick_roll","value":"Never Gonna Give You Up"}');
});

it('is jsonserializable', function () {
    expect(
        RickRollComponent::make()->jsonSerialize()
    )->toMatchArray([
        'type' => 'rick_roll',
        'value' => 'Never Gonna Give You Up',
    ]);
});

it('is renderable', function () {
    expect(
        RickRollComponent::make()->render()
    )->toBe('Never Gonna Give You Up');
});

it('is stringable', function () {
    expect(
        RickRollComponent::make()->__toString()
    )->toBe('Never Gonna Give You Up');
});
