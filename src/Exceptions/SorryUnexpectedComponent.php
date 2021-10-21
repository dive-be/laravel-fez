<?php

namespace Dive\Fez\Exceptions;

use Exception;

class SorryUnexpectedComponent extends Exception
{
    public static function make(string $component): self
    {
        return new self("The provided component {$component} is invalid.");
    }
}
