<?php

namespace Dive\Fez\OpenGraph\Structures;

abstract class VisualMedium extends Medium
{
    public function alt(string $alt): self
    {
        return $this->setProperty(__FUNCTION__, $alt);
    }

    public function height(string $height): self
    {
        return $this->setProperty(__FUNCTION__, $height);
    }

    public function width(string $width): self
    {
        return $this->setProperty(__FUNCTION__, $width);
    }
}
