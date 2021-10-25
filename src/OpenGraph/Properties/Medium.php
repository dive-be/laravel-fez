<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph\Properties;

use Dive\Fez\OpenGraph\StructuredProperty;

abstract class Medium extends StructuredProperty
{
    public function mime(string $mime): static
    {
        return $this->setProperty('type', $mime);
    }

    public function secureUrl(string $url): static
    {
        return $this->setProperty(null, $url)->setProperty('secure_url', $url);
    }

    public function url(string $url, bool $secure = false): static
    {
        if ($secure) {
            return $this->secureUrl($url);
        }

        return $this->setProperty(null, $url)->setProperty(__FUNCTION__, $url);
    }
}
