<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Closure;
use Dive\Fez\AlternatePage;
use Dive\Fez\Component;
use Dive\Fez\Exceptions\UnknownFeatureException;
use Dive\Fez\Factories\Feature\AlternatePageFactory;
use Dive\Fez\Factories\Feature\MetaElementsFactory;
use Dive\Fez\Factories\Feature\OpenGraphFactory;
use Dive\Fez\Factories\Feature\TwitterCardsFactory;
use Dive\Fez\Feature;
use Dive\Fez\MetaElements;
use Dive\Fez\OpenGraph\RichObject;
use Dive\Fez\TwitterCards\Card;
use Dive\Utils\Makeable;

class FeatureFactory
{
    use Makeable;

    private Closure $localeResolver;

    private Closure $requestResolver;

    private Closure $urlResolver;

    public function __construct(
        private array $config,
    ) {}

    public function create(string $feature): Component
    {
        return match ($feature) {
            Feature::alternatePage() => $this->alternatePage(),
            Feature::metaElements() => $this->metaElements(),
            Feature::openGraph() => $this->openGraph(),
            Feature::twitterCards() => $this->twitterCards(),
            default => throw UnknownFeatureException::make($feature),
        };
    }

    protected function alternatePage(): AlternatePage
    {
        return AlternatePageFactory::make(
            call_user_func($this->requestResolver),
        )->create(
            $this->locales()
        );
    }

    protected function metaElements(): MetaElements
    {
        return MetaElementsFactory::make(
            call_user_func($this->urlResolver),
        )->create(
            $this->mergeDefaults(Feature::metaElements())
        );
    }

    protected function openGraph(): RichObject
    {
        return OpenGraphFactory::make(
            call_user_func($this->localeResolver),
            call_user_func($this->urlResolver),
        )->create(
            $this->mergeDefaults(Feature::openGraph()) + ['alternates' => $this->locales()]
        );
    }

    protected function twitterCards(): Card
    {
        return TwitterCardsFactory::make()->create(
            $this->mergeDefaults(Feature::twitterCards())
        );
    }

    private function locales(): array
    {
        return $this->config['locales'];
    }

    private function mergeDefaults(string $feature): array
    {
        ['general' => $general] = $this->config['defaults'];

        // We're going to assume a localized description if the type's an array
        if (is_array($general['description'])) {
            $activeLocale = call_user_func($this->localeResolver);

            $general['description'] = $general['description'][$activeLocale];
        }

        return array_merge($general, $this->config['defaults'][$feature]);
    }

    public function setLocaleResolver(Closure $callback): self
    {
        $this->localeResolver = $callback;

        return $this;
    }

    public function setRequestResolver(Closure $callback): self
    {
        $this->requestResolver = $callback;

        return $this;
    }

    public function setUrlResolver(Closure $callback): self
    {
        $this->urlResolver = $callback;

        return $this;
    }
}
