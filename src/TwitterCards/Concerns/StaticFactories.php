<?php

namespace Dive\Fez\TwitterCards\Concerns;

use Dive\Fez\TwitterCards\Cards\Player;
use Dive\Fez\TwitterCards\Cards\Summary;
use Dive\Fez\TwitterCards\Cards\SummaryLargeImage;

trait StaticFactories
{
    public static function player(): Player
    {
        return Player::make();
    }

    public static function summary(): Summary
    {
        return Summary::make();
    }

    public static function summaryLargeImage(): SummaryLargeImage
    {
        return SummaryLargeImage::make();
    }
}
