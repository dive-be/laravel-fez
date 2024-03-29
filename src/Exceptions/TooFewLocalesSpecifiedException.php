<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use Exception;

class TooFewLocalesSpecifiedException extends Exception
{
    public static function make(): self
    {
        return new self('You must specify at least 2 distinct locales to render alternate page URLs.');
    }
}
