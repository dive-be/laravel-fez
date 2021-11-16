<?php declare(strict_types=1);

namespace Tests\Unit\MetaElements;

use Dive\Fez\MetaElements\Element;

it('is renderable', function () {
    expect(
        Element::make('<script>dive</script>', '<script>interactive</script>')->render()
    )->toBe(
        '<meta name="&lt;script&gt;dive&lt;/script&gt;" content="&lt;script&gt;interactive&lt;/script&gt;" />'
    );
});

it('is arrayable', function () {
    expect(
        Element::make('dive', 'interactive')->toArray()
    )->toMatchArray([
        'attributes' => [
            'content' => 'interactive',
            'name' => 'dive',
        ],
        'type' => 'element',
    ]);
});
