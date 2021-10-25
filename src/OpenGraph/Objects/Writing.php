<?php

namespace Dive\Fez\OpenGraph\Objects;

use Dive\Fez\OpenGraph\RichObject;

abstract class Writing extends RichObject
{
    public function author(string $author): static
    {
        return $this->pushProperty([__FUNCTION__, $author]);
    }

    public function tag(string $tag): static
    {
        return $this->pushProperty([__FUNCTION__, $tag]);
    }
}
