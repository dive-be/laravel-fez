<?php

namespace Dive\Fez\TwitterCards;

final class SummaryLargeImage extends Card
{
    public function creator(string $creator): self
    {
        return $this->setProperty(__FUNCTION__, $creator);
    }
}
