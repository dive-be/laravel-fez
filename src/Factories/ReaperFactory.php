<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Contracts\Reaper;
use Dive\Fez\Exceptions\SorryUnknownReaperStrategy;
use Dive\Fez\Reapers\BindingReaper;
use Dive\Fez\Reapers\NameReaper;
use Dive\Fez\Reapers\NullReaper;
use Dive\Fez\Reapers\RelevanceReaper;
use Dive\Fez\Support\Makeable;

class ReaperFactory
{
    use Makeable;

    public function create(string $strategy, array $attributes = []): Reaper
    {
        return match ($strategy) {
            'binding' => BindingReaper::make(...$attributes),
            'name' => NameReaper::make(),
            'null' => NullReaper::make(),
            'relevance' => RelevanceReaper::make(),
            default => throw SorryUnknownReaperStrategy::make($strategy),
        };
    }
}
