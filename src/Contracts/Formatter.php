<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

interface Formatter
{
    public function format(string $value): string;
}
