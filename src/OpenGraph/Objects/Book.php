<?php

namespace Dive\Fez\OpenGraph\Objects;

use DateTimeInterface;
use Dive\Fez\OpenGraph\Property;
use Dive\Fez\OpenGraph\RichObject;

final class Book extends RichObject
{
    public function author(string $author): self
    {
        return $this->pushProperty(Property::make(__FUNCTION__, $author));
    }

    public function isbn(string $isbn): self
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $isbn));
    }

    public function releaseDate(DateTimeInterface $releaseDate): self
    {
        return $this->setProperty(
            __FUNCTION__,
            Property::make('release_date', $releaseDate->format(DateTimeInterface::ISO8601)),
        );
    }

    public function tag(string $tag): self
    {
        return $this->pushProperty(Property::make(__FUNCTION__, $tag));
    }
}
