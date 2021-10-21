<?php

namespace Dive\Fez\Exceptions;

use Exception;

class SorryTooFewLocalesSpecified extends Exception
{
    public static function make(): self
    {
        return new self('You must specify at least 2 distinct locales to generate alternate page URLs.');
    }
}
