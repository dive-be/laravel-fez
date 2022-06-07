<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class MetableNotFoundException extends Exception
{
    public static function make(): self
    {
        return new self('You are not supposed to see this. Please submit a bug report.');
    }

    public static function throw(): never
    {
        throw self::make();
    }
}
