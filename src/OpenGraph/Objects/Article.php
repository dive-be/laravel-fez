<?php

namespace Dive\Fez\Objects\OpenGraph;

use DateTimeInterface;
use Dive\Fez\OpenGraph\RichObject;

final class Article extends RichObject
{
    // TODO: Allow multiple authors
    public function author(string $author): self
    {
        return $this->setProperty(__FUNCTION__, $author);
    }

    public function expirationTime(DateTimeInterface $expirationTime): self
    {
        return $this->setTimeProperty('expiration', $expirationTime);
    }

    public function modifiedTime(DateTimeInterface $modifiedTime): self
    {
        return $this->setTimeProperty('modified', $modifiedTime);
    }

    public function publishedTime(DateTimeInterface $publishedTime): self
    {
        return $this->setTimeProperty('published', $publishedTime);
    }

    public function section(string $section): self
    {
        return $this->setProperty(__FUNCTION__, $section);
    }

    // TODO: Allow multiple tags
    public function tag(string $tag): self
    {
        return $this->setProperty(__FUNCTION__, $tag);
    }

    private function setTimeProperty(string $type, DateTimeInterface $time): self
    {
        return $this->setProperty("{$type}_time", $time->format(DateTimeInterface::ISO8601));
    }
}
