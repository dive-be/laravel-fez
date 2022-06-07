<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class MetableNotFoundException extends Exception
{
    public static function throw(): self
    {
        throw new self('You are not supposed to see this. Please submit a bug report.');
    }
}
