<?php

namespace Dive\Fez\MetaElements;

use Dive\Fez\Component;
use Dive\Fez\Contracts\Formatter;

class Title extends Component
{
    public function __construct(private Formatter $formatter, private string $value) {}

    public function generate(): string
    {
        return "<title>{$this->formatted()}</title>";
    }

    public function toArray(): array
    {
        return ['title' => $this->formatted()];
    }

    private function formatted(): string
    {
        return $this->formatter->format($this->value);
    }
}
