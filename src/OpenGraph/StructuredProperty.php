<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Container;
use Illuminate\Support\Str;

abstract class StructuredProperty extends Container
{
    protected string $type;

    public function __construct()
    {
        $this->type = (string) Str::of(static::class)->classBasename()->lower();
    }

    public function setProperty(string $name, string $content): static
    {
        return parent::set($name, Property::make($name, $content));
    }

    public function type(): string
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return [
            'properties' => parent::toArray(),
            'type' => (string) Str::of(static::class)->classBasename()->lower(),
        ];
    }
}
