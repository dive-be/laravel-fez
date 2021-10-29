<?php declare(strict_types=1);

namespace Dive\Fez\Factories\Feature;

use Dive\Fez\Factories\CardFactory;
use Dive\Fez\Support\Makeable;
use Dive\Fez\TwitterCards\Card;

class TwitterCardsFactory
{
    use Makeable;

    private CardFactory $factory;

    public function __construct(
        private array $config,
    ) {
        $this->factory = CardFactory::make();
    }

    public function create(): Card
    {
        return $this->factory->create($this->config['type'])
            ->when($image = $this->config['image'],
                static fn (Card $card) => $card->image($image),
            )->when($description = $this->config['description'],
                static fn (Card $card) => $card->description($description)
            )->when($site = $this->config['site'],
                static fn (Card $card) => $card->site($site)
            );
    }
}
