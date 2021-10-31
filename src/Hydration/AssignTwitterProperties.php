<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Factories\CardFactory;
use Dive\Fez\Feature;
use Dive\Fez\FezManager;
use Dive\Fez\TwitterCards\Card;

class AssignTwitterProperties
{
    public function __construct(
        private FezManager $fez,
    ) {}

    public function handle(MetaData $data, Closure $next): MetaData
    {
        if (
            ! $this->fez->has(Feature::twitterCards()) ||
            empty($source = $data->twitterCards())
        ) {
            return $next($data);
        }

        $target = $this->selectTarget($this->fez->twitterCards, $source['type']);
        $target = $this->assign($target, $source);

        $this->fez->twitterCards = $target;

        return $next($data);
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
