<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

use Illuminate\Routing\Route;

interface Finder
{
    public function find(Route $route): ?Metable;
}
