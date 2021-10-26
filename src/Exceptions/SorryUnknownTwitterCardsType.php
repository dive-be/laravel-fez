<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class SorryUnknownTwitterCardsType extends Exception
{
    public static function make(string $type): self
    {
        return new self("The twitter cards type `{$type}` is invalid");
    }
}
