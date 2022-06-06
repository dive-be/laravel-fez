<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class UnspecifiedUrlResolverException extends Exception
{
    public static function make(): self
    {
        return new self('You must register an alternate URL resolver first.');
    }
}
