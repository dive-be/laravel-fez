<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class BadMethodCallException extends Exception
{
    public static function make(string $class, string $method): self
    {
        return new self("Method {$class}::{$method} does not exist.");
    }
}
