<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class UnknownFinderException extends Exception
{
    public static function make(string $strategy): self
    {
        return new self("The finder strategy `{$strategy}` is invalid");
    }
}
