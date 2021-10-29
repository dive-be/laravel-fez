<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Exceptions\SorryUnknownTwitterCardsType;
use Dive\Fez\Support\Makeable;
use Dive\Fez\TwitterCards\Card;
use Dive\Fez\TwitterCards\Cards\Player;
use Dive\Fez\TwitterCards\Cards\Summary;
use Dive\Fez\TwitterCards\Cards\SummaryLargeImage;

class CardFactory
{
    use Makeable;

    public function create(string $type): Card
    {
        return match ($type) {
            'player' => Player::make(),
            'summary' => Summary::make(),
            'summary_large_image' => SummaryLargeImage::make(),
            default => throw SorryUnknownTwitterCardsType::make($type),
        };
    }
}
