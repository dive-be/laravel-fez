<?php

namespace Dive\Fez\OpenGraph\Objects;

use DateTimeInterface;
use Dive\Fez\OpenGraph\Property;
use Dive\Fez\OpenGraph\RichObject;

final class Article extends RichObject
{
    public function author(string $author): self
    {
        return $this->pushProperty(Property::make(__FUNCTION__, $author));
    }

    public function expirationTime(DateTimeInterface $expirationTime): self
    {
        return $this->setProperty(
            __FUNCTION__,
            Property::make('expiration_time', $expirationTime->format(DateTimeInterface::ISO8601)),
        );
    }

    public function modifiedTime(DateTimeInterface $modifiedTime): self
    {
        return $this->setProperty(
            __FUNCTION__,
            Property::make('modified_time', $modifiedTime->format(DateTimeInterface::ISO8601)),
        );
    }

    public function publishedTime(DateTimeInterface $publishedTime): self
    {
        return $this->setProperty(
            __FUNCTION__,
            Property::make('published_time', $publishedTime->format(DateTimeInterface::ISO8601)),
        );
    }

    public function section(string $section): self
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $section));
    }

    public function tag(string $tag): self
    {
        return $this->pushProperty(Property::make(__FUNCTION__, $tag));
    }
}
