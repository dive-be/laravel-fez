<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Collectable;
use Dive\Fez\Contracts\Generable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use JsonSerializable;

class Fez implements Arrayable, Collectable, Generable, Htmlable, Jsonable, JsonSerializable
{
    public function generate(): string
    {
        return '';
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return [];
    }

    public function toCollection(): Collection
    {
        return Collection::make($this->toArray());
    }

    public function toHtml()
    {
        return $this->generate();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
