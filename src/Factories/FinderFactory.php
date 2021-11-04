<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Contracts\Finder;
use Dive\Fez\Exceptions\SorryUnknownFinderStrategy;
use Dive\Fez\Finders\BindingFinder;
use Dive\Fez\Finders\NameFinder;
use Dive\Fez\Finders\NullFinder;
use Dive\Fez\Finders\RelevanceFinder;
use Dive\Fez\Finders\SmartFinder;
use Dive\Fez\Support\Makeable;

class FinderFactory
{
    use Makeable;

    public function create(string $strategy, array $attributes = []): Finder
    {
        return match ($strategy) {
            'binding' => BindingFinder::make(...$attributes),
            'name' => NameFinder::make(call_user_func([$attributes['model'], 'query'])),
            'null' => NullFinder::make(),
            'relevance' => RelevanceFinder::make(),
            'smart' => SmartFinder::make($this, $attributes),
            default => throw SorryUnknownFinderStrategy::make($strategy),
        };
    }
}
