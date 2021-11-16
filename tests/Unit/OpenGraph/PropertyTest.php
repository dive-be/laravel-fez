<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph;

use Dive\Fez\OpenGraph\Property;

it('is arrayable', function () {
    expect(
        Property::make('dive', 'interactive')->toArray()
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
        Property::make('<script>dive</script>', '<script>interactive</script>')->render()
    )->toBe(
        '<meta property="og:&lt;script&gt;dive&lt;/script&gt;" content="&lt;script&gt;interactive&lt;/script&gt;" />'
    );
});
