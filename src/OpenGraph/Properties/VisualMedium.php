<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph\Properties;

abstract class VisualMedium extends Medium
{
    public function alt(string $alt): static
    {
        return $this->setProperty("{$this->type}:alt", $alt);
    }

    public function height(string $height): static
    {
        return $this->setProperty("{$this->type}:height", $height);
    }

    public function width(string $width): static
    {
        return $this->setProperty("{$this->type}:width", $width);
    }
}
