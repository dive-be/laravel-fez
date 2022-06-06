<?php declare(strict_types=1);

namespace Dive\Fez\Formatters;

use Dive\Fez\Contracts\Formatter;
use Dive\Utils\Makeable;

class DefaultFormatter implements Formatter
{
    use Makeable;

    public function __construct(
        private string $suffix,
        private string $separator,
    ) {}

    public function format(string $value = ''): string
    {
        if (empty($value)) {
            return $this->suffix;
        }

        return "{$value} {$this->separator} {$this->suffix}";
    }
}
