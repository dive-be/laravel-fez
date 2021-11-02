<?php declare(strict_types=1);

namespace Tests\Unit\Factories;

use Dive\Fez\Exceptions\SorryUnknownOpenGraphObjectType;
use Dive\Fez\Factories\RichObjectFactory;
use Dive\Fez\OpenGraph\Objects\Article;
use Dive\Fez\OpenGraph\Objects\Book;
use Dive\Fez\OpenGraph\Objects\Profile;
use Dive\Fez\OpenGraph\Objects\Website;

it('creates the correct object for the given type', function (string $type, string $class) {
    expect(RichObjectFactory::make()->create($type))->toBeInstanceOf($class);
})->with([
    ['article', Article::class],
    ['book', Book::class],
    ['profile', Profile::class],
    ['website', Website::class],
]);

it('throws if an unknown type is given', function () {
    RichObjectFactory::make()->create('Never Gonna Give You Up');
})->throws(SorryUnknownOpenGraphObjectType::class);
