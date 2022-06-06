<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class UnknownFeatureException extends Exception
{
    public static function make(string $feature): self
    {
        return new self("The feature `{$feature}` is invalid.");
    }
}
