<?php

namespace Dive\Fez\Exceptions;

use Exception;

class SorryNoFeaturesActive extends Exception
{
    public static function make(): self
    {
        return new self('You must enable at least one feature you would like to use with Fez.');
    }
}
