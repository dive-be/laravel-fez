<?php

namespace Dive\Fez\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public static function make(string $property, array|string $value): self
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        return new self("The '{$property}' property and/or '{$value}' value is invalid.");
    }
}
