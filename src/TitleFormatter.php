<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Support\Makeable;

class TitleFormatter implements Formatter
{
    use Makeable;

    public function __construct(private ?string $suffix, private ?string $separator) {}

    public function format(?string $value): string
    {
        if (is_null($this->suffix) || is_null($this->separator)) {
            return $value ?? '';
        }

        return $value.' '.$this->separator.' '.$this->suffix;
    }
}
