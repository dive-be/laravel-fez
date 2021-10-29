<?php

namespace Dive\Fez\Contracts;

use Illuminate\Routing\Route;

interface Reaper
{
    public function reap(Route $route): ?Metable;
}
