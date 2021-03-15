<?php

namespace Dive\Fez\Contracts;

interface Formatter
{
    public function format(string $value): string;
}
