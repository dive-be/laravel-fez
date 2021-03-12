<?php

namespace Dive\Fez\Containers;

use Dive\Fez\Contracts\Collectable;
use Dive\Fez\Contracts\Generable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use JsonSerializable;

abstract class Container implements Arrayable, Collectable, Generable, Htmlable, Jsonable, JsonSerializable
{
    abstract public function generate(): string;

    abstract public function toArray(): array;

    public function jsonSerialize(): array
    {
        return $this->toArray();
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
