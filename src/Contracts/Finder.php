<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

use Illuminate\Routing\Route;

interface Finder
{
    /**
     * @throws \Dive\Fez\Exceptions\MetableNotFoundException
     */
    public function find(Route $route): Metable;
}
