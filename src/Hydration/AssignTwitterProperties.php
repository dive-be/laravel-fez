<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Factories\CardFactory;
use Dive\Fez\Feature;
use Dive\Fez\FezManager;
use Dive\Fez\TwitterCards\Card;

class AssignTwitterProperties
{
    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (
            ! $fez->has(Feature::twitterCards()) ||
            empty($source = $fez->metaData()->twitterCards())
        ) {
            return $next($fez);
        }

        $target = $this->selectTarget($fez->twitterCards, $source['type']);
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

    private function selectTarget(Card $current, string $source): Card
    {
        return $current->type() === $source
            ? $current
            : CardFactory::make()->create($source);
    }
}
