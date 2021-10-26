<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Generable;
use Dive\Fez\Support\Makeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Stringable;

abstract class Component implements Arrayable, Generable, Htmlable, Jsonable, JsonSerializable, Stringable
{
    use Makeable;

    abstract public function generate(): string;

    abstract public function toArray(): array;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toHtml(): string
    {
        return $this->generate();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString(): string
    {
        return $this->generate();
    }
}
