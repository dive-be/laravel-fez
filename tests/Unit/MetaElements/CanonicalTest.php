<?php declare(strict_types=1);

namespace Tests\Unit\MetaElements;

use Dive\Fez\MetaElements\Canonical;

beforeEach(function () {
    $this->el = Canonical::make('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
});

it('is renderable', function () {
    expect(
        $this->el->render()
    )->toBe(
        '<link rel="canonical" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" />'
    );
});

it('is arrayable', function () {
    expect(
        $this->el->toArray()
    )->toMatchArray([
        'attributes' => [
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ],
        'type' => 'canonical',
    ]);
});
