<?php declare(strict_types=1);

namespace Dive\Fez\TwitterCards;

use Dive\Fez\ComponentBag;
use Illuminate\Support\Str;

abstract class Card extends ComponentBag
{
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);

        $this->setProperty('card', (string) Str::of(static::class)->classBasename()->snake()->lower());
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
}
