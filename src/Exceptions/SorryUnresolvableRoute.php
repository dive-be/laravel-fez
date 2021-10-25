<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class SorryUnresolvableRoute extends Exception
{
    public static function make(): self
    {
        return new self('No route context could be resolved. Calling it too soon?');
    }
}
