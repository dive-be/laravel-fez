<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph;

use Dive\Fez\ComponentBag;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

abstract class StructuredProperty extends ComponentBag
{
    protected function setProperty(?string $name, string $value): static
    {
        $name = (string) Str::of(static::class)
            ->classBasename()
            ->lower()
            ->unless(is_null($name), fn (Stringable $str) => $str->append(":{$name}"));

        return parent::set($name, Property::make($name, $value));
    }

    public function toArray(): array
    {
        return [
            'properties' => parent::toArray(),
            'type' => (string) Str::of(static::class)->classBasename()->lower(),
        ];
    }
}
