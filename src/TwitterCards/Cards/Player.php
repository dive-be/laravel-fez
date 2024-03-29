<?php declare(strict_types=1);

namespace Dive\Fez\TwitterCards\Cards;

use Dive\Fez\TwitterCards\Card;

class Player extends Card
{
    public function height(int $height): self
    {
        return $this->setProperty('player:height', (string) $height);
    }

    public function url(string $url): self
    {
        return $this->setProperty('player', $url);
    }

    public function width(int $width): self
    {
        return $this->setProperty('player:width', (string) $width);
    }
}
