<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class SorryUnknownReaperStrategy extends Exception
{
    public static function make(string $strategy): self
    {
        return new self("The reaper strategy `{$strategy}` is invalid");
    }
}
