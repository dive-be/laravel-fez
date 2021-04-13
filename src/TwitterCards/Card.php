<?php

namespace Dive\Fez\TwitterCards;

use Dive\Fez\Container;
use Illuminate\Support\Str;

abstract class Card extends Container
{
    public function __construct(array|string $properties = [])
    {
        if (is_string($properties)) {
            $properties = ['title' => Property::make('title', $properties)];
        }

        parent::__construct($this->initialize($properties));
    }

    public function description(string $description): static
    {
        return $this->setProperty(__FUNCTION__, $description);
    }

    public function image(string $image, ?string $alt = null): static
    {
        if (is_string($alt)) {
            $this->setProperty(__FUNCTION__.Property::DELIMITER.'alt', $alt);
        }

        return $this->setProperty(__FUNCTION__, $image);
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

    private function initialize(array $properties): array
    {
        foreach ($properties as $name => $property) {
            if (! $property instanceof Property) {
                $properties[$name] = Property::make($name, $property);
            }
        }

        return $properties + ['card' => Property::make('card', Str::lower(class_basename(static::class)))];
    }
}
