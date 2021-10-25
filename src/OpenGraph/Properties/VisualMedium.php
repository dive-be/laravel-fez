<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph\Properties;

abstract class VisualMedium extends Medium
{
    public function alt(string $alt): static
    {
        return $this->setProperty(__FUNCTION__, $alt);
    }

    public function height(string $height): static
    {
        return $this->setProperty(__FUNCTION__, $height);
    }

    public function width(string $width): static
    {
        return $this->setProperty(__FUNCTION__, $width);
    }
}
