<?php declare(strict_types=1);

namespace Tests\Fakes;

use Dive\Fez\Contracts\Formatter;

class RickRollFormatter implements Formatter
{
    public function format(string $value): string
    {
        return "Never Gonna Give You Up, {$value}!";
    }
}
