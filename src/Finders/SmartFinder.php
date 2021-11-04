<?php declare(strict_types=1);

namespace Dive\Fez\Finders;

use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Factories\FinderFactory;
use Dive\Fez\Support\Makeable;
use Illuminate\Routing\Route;

class SmartFinder implements Finder
{
    use Makeable;

    public function __construct(
        private FinderFactory $factory,
        private array $attributes,
    ) {}

    public function find(Route $route): ?Metable
    {
        if ($this->isProbablyDetail($route->uri())) {
            return $this->factory->create('relevance')->find($route);
        }

        return $this->factory->create('name', $this->attributes)->find($route);
    }

    private function isProbablyDetail(string $uri): bool
    {
        return str_ends_with($uri, '}');
    }
}
