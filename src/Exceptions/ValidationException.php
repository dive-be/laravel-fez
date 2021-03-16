<?php

namespace Dive\Fez\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public static function make(string $type, string $property): self
    {
        return new self("The {$type} property '{$property}' is invalid.");
    }
}
