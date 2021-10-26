<?php declare(strict_types=1);

namespace Dive\Fez;

use Closure;
use Dive\Fez\Exceptions\SorryUnexpectedComponent;
use Dive\Fez\Support\Makeable;

class FeatureFactory
{
    use Makeable;

    private Closure $requestResolver;

    public function __construct(private array $config) {}

    public function create(string $feature): Component
    {
        return match ($feature) {
            Feature::alternatePage() => $this->alternatePage(),
            default => throw SorryUnexpectedComponent::make($feature),
        };
    }

    private function alternatePage(): AlternatePage
    {
        return AlternatePage::make($this->config['locales'], call_user_func($this->requestResolver));
    }

    public function setRequestResolver(Closure $callback): self
    {
        $this->requestResolver = $callback;

        return $this;
    }
}
