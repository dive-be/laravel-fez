<?php declare(strict_types=1);

namespace Dive\Fez\Reapers;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Contracts\Reaper;
use Dive\Fez\Support\Makeable;
use Illuminate\Routing\Route;

class NullReaper implements Reaper
{
    use Makeable;

    public function reap(Route $route): ?Metable
    {
        return null;
    }
}
