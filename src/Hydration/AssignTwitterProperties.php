<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Exceptions\SorryUnknownTwitterCardsType;
use Dive\Fez\FezManager;
use Dive\Fez\TwitterCards;
use Dive\Fez\TwitterCards\Card;

class AssignTwitterProperties
{
    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (empty($source = $fez->metaData()->twitterCards())) {
            return $next($fez);
        }

        $target = $this->selectTarget($fez->twitterCards, $source);
        $target = $this->assign($target, $source);

        $fez->twitterCards = $target;

        return $next($fez);
    }

    private function assign(Card $target, array $source): Card
    {
        foreach ($source['properties'] as $property) {
            $target->setProperty(...$property['attributes']);
        }

        return $target;
    }

    private function createCard(string $type): Card
    {
        return match ($type) {
            'player' => TwitterCards::player(),
            'summary' => TwitterCards::summary(),
            'summary_large_image' => TwitterCards::summaryLargeImage(),
            default => throw SorryUnknownTwitterCardsType::make($type),
        };
    }

    private function selectTarget(Card $current, array $source): Card
    {
        $type = $source['type'];

        if ($current->type() === $type) {
            return $current;
        }

        return $this->createCard($type);
    }
}
