<?php declare(strict_types=1);

namespace Tests\Unit\MetaElements;

use Dive\Fez\MetaElements\Title;

it('is renderable', function () {
    expect(
        Title::make('<script>Never Gonna Give You Up</script>')->render()
    )->toBe(
        '<title>&lt;script&gt;Never Gonna Give You Up&lt;/script&gt;</title>'
    );
});

it('is arrayable', function () {
    expect(
        Title::make('Never Gonna Give You Up')->toArray()
    )->toMatchArray([
        'attributes' => [
            'value' => 'Never Gonna Give You Up',
        ],
        'type' => 'title',
    ]);
});
