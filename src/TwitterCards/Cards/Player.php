<?php

namespace Dive\Fez\TwitterCards\Cards;

use Dive\Fez\TwitterCards\Card;

final class Player extends Card
{
    public function height(int $height): self
    {
        return $this->setProperty('player:height', $height);
    }

    public function url(string $url): self
    {
        return $this->setProperty('player', $url);
    }

    public function width(int $width): self
    {
        return $this->setProperty('player:width', $width);
    }
}
