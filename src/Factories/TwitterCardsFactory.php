<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Exceptions\SorryUnknownTwitterCardsType;
use Dive\Fez\Support\Makeable;
use Dive\Fez\TwitterCards\Card;
use Dive\Fez\TwitterCards\Cards\Player;
use Dive\Fez\TwitterCards\Cards\Summary;
use Dive\Fez\TwitterCards\Cards\SummaryLargeImage;

class TwitterCardsFactory
{
    use Makeable;

    public function __construct(
        private array $config,
    ) {}

    public function create(): Card
    {
        return $this->newCard()
            ->when($image = $this->config['image'],
                static fn (Card $card) => $card->image($image),
            )->when($description = $this->config['description'],
                static fn (Card $card) => $card->description($description)
            )->when($site = $this->config['site'],
                static fn (Card $card) => $card->site($site)
            );
    }

    protected function newCard(): Card
    {
        return call_user_func([$this->getClass($this->config['type']), 'make']);
    }

    private function getClass(string $type): string
    {
        return match ($type) {
            'player' => Player::class,
            'summary' => Summary::class,
            'summary_large_image' => SummaryLargeImage::class,
            default => throw SorryUnknownTwitterCardsType::make($type),
        };
    }
}
