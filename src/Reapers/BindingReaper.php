<?php

namespace Dive\Fez\Reapers;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Contracts\Reaper;
use Dive\Fez\Support\Makeable;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;

class BindingReaper implements Reaper
{
    use Makeable;

    public function __construct(
        private string $parameterName,
    ) {}

    public function reap(Route $route): ?Metable
    {
        return Arr::get($route->parameters, $this->parameterName);
    }
}
