<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph;

use Dive\Fez\OpenGraph\Properties\Image;

beforeEach(function () {
    $this->prop = Image::make(); // only the abstract StructuredProperty behavior is tested
});

it('is arrayable', function () {
    expect(
        $this->prop->toArray()
    )->toMatchArray([
        'properties' => [],
        'type' => 'image',
    ]);
});

it('can set a property', function () {
    $this->prop->setProperty('rick', 'astley');

    expect($this->prop->rick)->content()->toBe('astley');
});

it('can retrieve type', function () {
    expect($this->prop->type())->toBe('image');
});
