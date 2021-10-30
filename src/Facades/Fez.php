<?php declare(strict_types=1);

namespace Dive\Fez\Facades;

use Illuminate\Support\Facades\Facade;

class Fez extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fez';
    }
}
