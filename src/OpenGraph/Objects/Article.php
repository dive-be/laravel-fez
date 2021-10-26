<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph\Objects;

use DateTimeInterface;

class Article extends Writing
{
    public function expirationTime(DateTimeInterface $expirationTime): self
    {
        return $this->setProperty('expiration_time', $expirationTime->format(DateTimeInterface::ISO8601));
    }

    public function modifiedTime(DateTimeInterface $modifiedTime): self
    {
        return $this->setProperty('modified_time', $modifiedTime->format(DateTimeInterface::ISO8601));
    }

    public function publishedTime(DateTimeInterface $publishedTime): self
    {
        return $this->setProperty('published_time', $publishedTime->format(DateTimeInterface::ISO8601));
    }

    public function section(string $section): self
    {
        return $this->setProperty(__FUNCTION__, $section);
    }
}
