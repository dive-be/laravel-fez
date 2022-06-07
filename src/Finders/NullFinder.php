<?php declare(strict_types=1);

namespace Dive\Fez\Finders;

use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\MetableNotFoundException;
use Dive\Utils\Makeable;
use Illuminate\Routing\Route;

class NullFinder implements Finder
{
    use Makeable;

    public function find(Route $route): Metable
    {
        throw MetableNotFoundException::make();
    }
}
