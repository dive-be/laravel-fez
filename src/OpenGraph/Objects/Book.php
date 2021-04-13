<?php

namespace Dive\Fez\OpenGraph\Objects;

use DateTimeInterface;

final class Book extends Writing
{
    public function isbn(string $isbn): self
    {
        return $this->setProperty(__FUNCTION__, $isbn);
    }

    public function releaseDate(DateTimeInterface $releaseDate): self
    {
        return $this->setProperty('release_date', $releaseDate->format(DateTimeInterface::ISO8601));
    }
}
