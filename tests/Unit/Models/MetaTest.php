<?php declare(strict_types=1);

namespace Tests\Unit\Models;

use Dive\Fez\Models\Meta;

it('defines casts', function () {
    expect((new Meta())->getCasts())->toMatchArray([
        'elements' => 'array',
        'open_graph' => 'array',
        'twitter' => 'array',
    ]);
});

it('defines a singular table name', function () {
    expect((new Meta())->getTable())->toBe('meta');
});

it('defines a data getter', function () {
    expect((new Meta())->data())->toHaveKeys([
        'description',
        'elements',
        'image',
        'open_graph',
        'title',
        'twitter',
    ]);
});

it('defines a metable relation', function () {
    expect(method_exists(new Meta(), 'metable'))->toBeTrue();
});
