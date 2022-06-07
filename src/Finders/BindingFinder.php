<?php declare(strict_types=1);

namespace Dive\Fez\Finders;

use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\MetableNotFoundException;
use Dive\Utils\Makeable;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;

class BindingFinder implements Finder
{
    use Makeable;

    public function __construct(
        private string $parameterName,
    ) {}

    public function find(Route $route): Metable
    {
        return Arr::get($route->parameters, $this->parameterName, MetableNotFoundException::throw(...));
    }
}
