<?php declare(strict_types=1);

namespace Tests\Unit\Factories;

use Dive\Fez\Exceptions\SorryUnknownOpenGraphObjectType;
use Dive\Fez\Factories\StructuredPropertyFactory;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\OpenGraph\Properties\Image;
use Dive\Fez\OpenGraph\Properties\Video;

it('creates the correct structured property for the given type', function (string $type, string $class) {
    expect(StructuredPropertyFactory::make()->create($type))->toBeInstanceOf($class);
})->with([
    ['audio', Audio::class],
    ['image', Image::class],
    ['video', Video::class],
]);

it('throws if an unknown type is given', function () {
    StructuredPropertyFactory::make()->create('Never Gonna Give You Up');
})->throws(SorryUnknownOpenGraphObjectType::class);
