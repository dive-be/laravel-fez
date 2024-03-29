<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Formatters\DefaultFormatter;
use Dive\Fez\Formatters\NullFormatter;

class FormatterFactory
{
    public function create(array|string|null $config): Formatter
    {
        if (is_string($config)
            && class_exists($config)
            && array_key_exists(Formatter::class, class_implements($config))
        ) {
            return new $config();
        }

        if (is_array($config)) {
            return DefaultFormatter::make($config['suffix'], $config['separator']);
        }

        return NullFormatter::make();
    }
}
