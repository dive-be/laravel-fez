<?php declare(strict_types=1);

namespace Tests\Unit\MetaElements;

use Dive\Fez\MetaElements\Canonical;

it('is renderable', function () {
    expect(
        Canonical::make('<script>Edgy Content</script>')->render()
    )->toBe(
        '<link rel="canonical" href="&lt;script&gt;Edgy Content&lt;/script&gt;" />'
    );
});

it('is arrayable', function () {
    expect(
        Canonical::make('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->toArray()
    )->toMatchArray([
        'attributes' => [
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ],
        'type' => 'canonical',
    ]);
});
