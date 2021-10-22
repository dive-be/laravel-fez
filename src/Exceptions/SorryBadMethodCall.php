<?php

namespace Dive\Fez\Exceptions;

use BadMethodCallException;

class SorryBadMethodCall extends BadMethodCallException
{
    public static function make(string $class, string $method): self
    {
        return new self("Method {$class}::{$method} does not exist.");
    }
}
