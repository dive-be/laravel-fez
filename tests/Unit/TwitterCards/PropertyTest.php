<?php declare(strict_types=1);

namespace Tests\Unit\TwitterCards;

use Dive\Fez\TwitterCards\Property;

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
        '<meta name="twitter:&lt;script&gt;dive&lt;/script&gt;" content="&lt;script&gt;interactive&lt;/script&gt;" />'
    );
});
