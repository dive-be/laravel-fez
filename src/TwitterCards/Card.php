<?php

namespace Dive\Fez\TwitterCards;

use Dive\Fez\Container;

abstract class Card extends Container
{
    public function description(string $description): static
    {
        return $this->setProperty(__FUNCTION__, $description);
    }

    public function image(string $image): static
    {
        return $this->setProperty(__FUNCTION__, $image);
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
