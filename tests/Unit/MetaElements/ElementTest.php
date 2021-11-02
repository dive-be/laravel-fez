<?php declare(strict_types=1);

namespace Tests\Unit\MetaElements;

use Dive\Fez\MetaElements\Element;

beforeEach(function () {
    $this->el = Element::make('dive', 'interactive');
});

it('is renderable', function () {
    expect(
        $this->el->render()
    )->toBe(
        '<meta name="dive" content="interactive" />'
    );
});

it('is arrayable', function () {
    expect(
        $this->el->toArray()
    )->toMatchArray([
        'attributes' => [
            'content' => 'interactive',
            'name' => 'dive',
        ],
        'type' => 'element',
    ]);
});
