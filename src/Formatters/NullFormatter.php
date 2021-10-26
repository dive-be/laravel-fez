<?php declare(strict_types=1);

namespace Dive\Fez\Formatters;

use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Support\Makeable;

class NullFormatter implements Formatter
{
    use Makeable;

    public function format(string $value): string
    {
        return $value;
    }
}
