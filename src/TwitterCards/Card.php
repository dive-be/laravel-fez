<?php declare(strict_types=1);

namespace Dive\Fez\TwitterCards;

use Dive\Fez\ComponentBag;
use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Titleable;
use Illuminate\Support\Str;

abstract class Card extends ComponentBag implements Describable, Titleable
{
    public const TYPE = 'card';

    public function __construct()
    {
        $this->setProperty(self::TYPE, $this->type());
    }

    public function description(string $description): static
    {
        return $this->setProperty(__FUNCTION__, $description);
    }

    public function image(string $image, ?string $alt = null): static
    {
        $this->setProperty(__FUNCTION__, $image);

        if (is_string($alt)) {
            $this->setProperty('image:alt', $alt);
        }

        return $this;
    }

    public function site(string $site): static
    {
        return $this->setProperty(__FUNCTION__, $site);
    }

    public function title(string $title): static
    {
        return $this->setProperty(__FUNCTION__, $title);
    }

    protected function setProperty(string $name, string $value): static
    {
        return parent::set($name, Property::make($name, $value));
    }

    private function type(): string
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
