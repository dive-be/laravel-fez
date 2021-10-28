<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class SorryPropertyNotFound extends Exception
{
    public static function make(string $class, string $property): self
    {
        return new self("Property {$class}::\${$property} could not be found.");
    }
}
