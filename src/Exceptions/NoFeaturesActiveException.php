<?php

namespace Dive\Fez\Exceptions;

use Exception;

class NoFeaturesActiveException extends Exception
{
    public static function make(): self
    {
        return new self('You must specify at least one feature you would like to use with Fez.');
    }
}
