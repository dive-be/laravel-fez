<?php

namespace Dive\Fez\Exceptions;

use Exception;

class UnresolvableRouteException extends Exception
{
    public static function make(): self
    {
        return new self('No route context could be resolved. Calling it too soon?');
    }
}
