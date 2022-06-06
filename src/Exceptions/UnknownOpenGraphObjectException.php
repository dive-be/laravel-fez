<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class UnknownOpenGraphObjectException extends Exception
{
    public static function make(string $type): self
    {
        return new self("The open graph object type `{$type}` is invalid");
    }
}
