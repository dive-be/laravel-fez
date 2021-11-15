<?php declare(strict_types=1);

namespace Tests\Unit\Factories;

use Dive\Fez\Exceptions\SorryUnknownFinderStrategy;
use Dive\Fez\Factories\FinderFactory;
use Dive\Fez\Finders\BindingFinder;
use Dive\Fez\Finders\IDFinder;
use Dive\Fez\Finders\NullFinder;
use Dive\Fez\Finders\RelevanceFinder;

it('creates the correct finder for the given strategy', function (string $strategy, string $class, array $args = []) {
   expect(FinderFactory::make()->create($strategy, $args))->toBeInstanceOf($class);
})->with([
    ['binding', BindingFinder::class, ['parameterName' => 'post']],
    ['id', IDFinder::class],
    ['null', NullFinder::class],
    ['relevance', RelevanceFinder::class],
]);

it('throws if an unknown strategy is given', function () {
    FinderFactory::make()->create('Never Gonna Give You Up');
})->throws(SorryUnknownFinderStrategy::class);
