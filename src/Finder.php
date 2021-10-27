<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Support\Makeable;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Finder
{
    use Makeable;

    public function __construct(
        private Route $route,
    ) {}

    public function find(): ?Metable
    {
        return $this->seekUsingBinding() ?? $this->seekMostRelevant();
    }

    private function seekMostRelevant(): ?Metable
    {
        return Collection::make($this->route->parameterNames)
            ->map(fn ($param) => Arr::get($this->route->parameters, $param))
            ->last(fn ($param) => $param instanceof Metable);
    }

    private function seekUsingBinding(): ?Metable
    {
        $binding = Arr::pull($this->route->defaults, static::class);

        if (! is_string($binding)) {
            return null;
        }

        return Arr::get($this->route->parameters, $binding);
    }
}
