<?php

namespace Dive\Fez\Exceptions;

use Exception;

class SorryInboundCastDisallowed extends Exception
{
    public static function make(): self
    {
        return new self('Inbound attribute casting is disallowed');
    }
}
