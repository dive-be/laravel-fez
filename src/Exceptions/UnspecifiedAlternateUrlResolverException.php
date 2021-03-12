<?php

namespace Dive\Fez\Exceptions;

use Exception;

class UnspecifiedAlternateUrlResolverException extends Exception
{
    public static function make(): self
    {
        return new self('You must register an alternate URL resolver first.');
    }
}
