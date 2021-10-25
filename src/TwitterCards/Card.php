<?php declare(strict_types=1);

namespace Dive\Fez\TwitterCards;

use Dive\Fez\Container;
use Illuminate\Support\Str;

abstract class Card extends Container
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
            $this->setProperty(__FUNCTION__ . Property::DELIMITER . 'alt', $alt);
        }

        return $this;
    }

    public function setProperty(string $name, $value): static
    {
        return parent::setProperty($name, is_string($value) ? Property::make($name, $value) : $value);
    }

    public function site(string $site): static
    {
        return $this->setProperty(__FUNCTION__, $site);
    }

    public function title(string $title): static
    {
        return $this->setProperty(__FUNCTION__, $title);
    }
}
