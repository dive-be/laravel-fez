<?php declare(strict_types=1);

namespace Dive\Fez\TwitterCards;

use Dive\Fez\Container;
use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Contracts\Titleable;
use Illuminate\Support\Str;

abstract class Card extends Container implements Describable, Imageable, Titleable
{
    public const TYPE = 'card';

    public function __construct()
    {
        $this->setProperty(self::TYPE, $this->type());
    }

    public function description(string $description): static
    {
        return $this->setProperty('description', $description);
    }

    public function image(string $image, ?string $alt = null): static
    {
        $this->setProperty('image', $image);

        if (is_string($alt)) {
            $this->setProperty('image:alt', $alt);
        }

        return $this;
    }

    public function site(string $site): static
    {
        return $this->setProperty('site', $site);
    }

    public function title(string $title): static
    {
        return $this->setProperty('title', $title);
    }

    public function setProperty(string $name, string $content): static
    {
        return parent::set($name, Property::make($name, $content));
    }

    public function type(): string
    {
        return (string) Str::of(static::class)->classBasename()->snake()->lower();
    }

    public function toArray(): array
    {
        return [
            'properties' => parent::toArray(),
            'type' => $this->type(),
        ];
    }
}
