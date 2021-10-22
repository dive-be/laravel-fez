<?php

namespace Dive\Fez\Exceptions;

use Exception;

class SorryPropertyNotFound extends Exception
{
    public static function make(string $property): self
    {
        return new self("Property [\${$property}] could not be found.");
    }
}
