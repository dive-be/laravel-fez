<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph;

use Dive\Fez\OpenGraph\Property;

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
        '<meta property="og:dive" content="interactive" />'
    );
});
