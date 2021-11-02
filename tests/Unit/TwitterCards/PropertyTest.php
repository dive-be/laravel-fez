<?php declare(strict_types=1);

namespace Tests\Unit\TwitterCards;

use Dive\Fez\TwitterCards\Property;

beforeEach(function () {
    $this->prop = Property::make('dive', 'interactive');
});

it('is arrayable', function () {
    expect(
        $this->prop->toArray()
    )->toMatchArray([
        'attributes' => [
            'content' => 'interactive',
            'name' => 'dive',
        ],
        'type' => 'property',
    ]);
});

it('is renderable', function () {
    expect(
        $this->prop->render()
    )->toBe(
        '<meta name="twitter:dive" content="interactive" />'
    );
});
