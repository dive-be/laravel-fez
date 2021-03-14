<?php

namespace Dive\Fez\Exceptions;

use Exception;

class UnexpectedComponentException extends Exception
{
    public static function make(string $component): self
    {
        return new self("The provided component {$component} is invalid.");
    }
}
