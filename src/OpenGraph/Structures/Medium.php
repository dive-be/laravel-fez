<?php

namespace Dive\Fez\OpenGraph\Structures;

use Dive\Fez\Container;

abstract class Medium extends Container
{
    public function mime(string $mime): self
    {
        return $this->setProperty('type', $mime);
    }

    public function secureUrl(string $url): self
    {
        return $this->setProperty('secure_url', $url);
    }

    public function url(string $url, bool $secure = false): self
    {
        if ($secure) {
            return $this->secureUrl($url);
        }

        return $this->setProperty(__FUNCTION__, $url);
    }
}
