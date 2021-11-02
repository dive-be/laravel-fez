<?php declare(strict_types=1);

namespace Tests\Unit\MetaElements;

use Dive\Fez\MetaElements\Title;

beforeEach(function () {
    $this->el = Title::make('Never Gonna Give You Up');
});

it('is renderable', function () {
    expect(
        $this->el->render()
    )->toBe(
        '<title>Never Gonna Give You Up</title>'
    );
});

it('is arrayable', function () {
    expect(
        $this->el->toArray()
    )->toMatchArray([
        'attributes' => [
            'value' => 'Never Gonna Give You Up',
        ],
        'type' => 'title',
    ]);
});
