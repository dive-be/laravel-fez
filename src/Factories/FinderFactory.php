<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Contracts\Finder;
use Dive\Fez\Exceptions\SorryUnknownFinderStrategy;
use Dive\Fez\Finders\BindingFinder;
use Dive\Fez\Finders\IDFinder;
use Dive\Fez\Finders\NullFinder;
use Dive\Fez\Finders\RelevanceFinder;
use Dive\Utils\Makeable;

class FinderFactory
{
    use Makeable;

    public function create(string $strategy, array $attributes = []): Finder
    {
        return match ($strategy) {
            'binding' => BindingFinder::make(...$attributes),
            'id' => IDFinder::make(),
            'null' => NullFinder::make(),
            'relevance' => RelevanceFinder::make(),
            default => throw SorryUnknownFinderStrategy::make($strategy),
        };
    }
}
