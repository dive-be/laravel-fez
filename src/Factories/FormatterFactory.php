<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Formatters\DefaultFormatter;
use Dive\Fez\Formatters\NullFormatter;
use Dive\Fez\Support\Makeable;

class FormatterFactory
{
    use Makeable;

    public function __construct(
        private array|string|null $config,
    ) {}

    public function create(): Formatter
    {
        if (is_string($this->config) && class_exists($this->config)) {
            return new ($this->config)();
        }

        if (is_array($this->config)) {
            return DefaultFormatter::make($this->config['suffix'], $this->config['separator']);
        }

        return NullFormatter::make();
    }
}
