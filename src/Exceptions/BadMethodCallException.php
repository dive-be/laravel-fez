<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use BadMethodCallException as Exception;

class BadMethodCallException extends Exception
{
    public static function make(string $class, string $method): self
    {
        return new self("Call to undefined method {$class}::{$method}(...)");
    }
}
