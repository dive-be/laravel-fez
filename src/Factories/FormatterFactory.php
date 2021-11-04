<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Formatters\DefaultFormatter;
use Dive\Fez\Formatters\NullFormatter;
use Dive\Fez\Support\Makeable;
use Illuminate\Container\Container;

class FormatterFactory
{
    use Makeable;

    public function create(array|string|null $config): Formatter
    {
        if (is_string($config) && class_exists($config)) {
            return Container::getInstance()->make($config);
        }

        if (is_array($config)) {
            return DefaultFormatter::make($config['suffix'], $config['separator']);
        }

        return NullFormatter::make();
    }
}
