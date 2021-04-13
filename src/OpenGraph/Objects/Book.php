<?php

namespace Dive\Fez\Objects\OpenGraph;

use DateTimeInterface;
use Dive\Fez\OpenGraph\RichObject;

final class Book extends RichObject
{
    // TODO: Allow multiple authors
    public function author(string $author): self
    {
        return $this->setProperty(__FUNCTION__, $author);
    }

    public function isbn(string $isbn): self
    {
        return $this->setProperty(__FUNCTION__, $isbn);
    }

    public function releaseDate(DateTimeInterface $releaseDate): self
    {
        return $this->setProperty('release_date', $releaseDate->format(DateTimeInterface::ISO8601));
    }

    // TODO: Allow multiple tags
    public function tag(string $tag): self
    {
        return $this->setProperty(__FUNCTION__, $tag);
    }
}
