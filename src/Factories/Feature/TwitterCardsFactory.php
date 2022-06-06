<?php declare(strict_types=1);

namespace Dive\Fez\Factories\Feature;

use Dive\Fez\Factories\CardFactory;
use Dive\Fez\TwitterCards\Card;
use Dive\Utils\Makeable;

class TwitterCardsFactory
{
    use Makeable;

    private CardFactory $factory;

    public function __construct()
    {
        $this->factory = CardFactory::make();
    }

    public function create(array $config): Card
    {
        return $this->factory->create($config['type'])
            ->when($image = $config['image'],
                static fn (Card $card) => $card->image($image),
            )->when($description = $config['description'],
                static fn (Card $card) => $card->description($description)
            )->when($site = $config['site'],
                static fn (Card $card) => $card->site($site)
            );
    }
}
