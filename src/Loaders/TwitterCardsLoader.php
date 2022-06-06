<?php declare(strict_types=1);

namespace Dive\Fez\Loaders;

use Dive\Fez\Contracts\Loader;
use Dive\Fez\Factories\CardFactory;
use Dive\Fez\Feature;
use Dive\Fez\Manager;
use Dive\Fez\MetaData;
use Dive\Fez\TwitterCards\Card;

class TwitterCardsLoader implements Loader
{
    public function load(Manager $fez, MetaData $data)
    {
        if (! $fez->has(Feature::twitterCards())) {
            return;
        }

        $source = $data->twitter;

        if (empty($source)) {
            return;
        }

        $target = $this->selectTarget($fez->twitterCards, $source['type']);
        $target = $this->assign($target, $source);

        $fez->twitterCards = $target;
    }

    private function assign(Card $target, array $source): Card
    {
        foreach ($source['properties'] as $property) {
            $target->setProperty(...$property['attributes']);
        }

        return $target;
    }

    private function selectTarget(Card $current, string $source): Card
    {
        return $current->type() === $source
            ? $current
            : CardFactory::make()->create($source);
    }
}
