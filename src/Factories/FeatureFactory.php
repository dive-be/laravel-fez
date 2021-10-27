<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Closure;
use Dive\Fez\AlternatePage;
use Dive\Fez\Component;
use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Exceptions\SorryUnknownFeature;
use Dive\Fez\Feature;
use Dive\Fez\MetaElements;
use Dive\Fez\OpenGraph\RichObject;
use Dive\Fez\Support\Makeable;
use Dive\Fez\TwitterCards\Card;

class FeatureFactory
{
    use Makeable;

    private Formatter $formatter;

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
            default => throw SorryUnknownFeature::make($feature),
        };
    }

    protected function alternatePage(): AlternatePage
    {
        return AlternatePageFactory::make(
            $this->locales(),
            call_user_func($this->requestResolver),
        )->create();
    }

    protected function metaElements(): MetaElements
    {
        return MetaElementsFactory::make(
            $this->mergeDefaults(__FUNCTION__),
            call_user_func($this->urlResolver),
        )->create();
    }

    protected function openGraph(): RichObject
    {
        return OpenGraphFactory::make(
            $this->mergeDefaults(__FUNCTION__) + ['alternates' => $this->locales()],
            call_user_func($this->localeResolver),
            call_user_func($this->urlResolver),
        )->create();
    }

    protected function twitterCards(): Card
    {
        return TwitterCardsFactory::make(
            $this->mergeDefaults(__FUNCTION__),
        )->create();
    }

    private function formatter(): Formatter
    {
        if (isset($this->formatter)) {
            return $this->formatter;
        }

        return $this->formatter = FormatterFactory::make($this->config['title'])->create();
    }

    private function locales(): array
    {
        return $this->config[__FUNCTION__];
    }

    private function mergeDefaults(string $feature): array
    {
        $defaults = $this->config['defaults'];

        return array_merge($defaults['general'], $defaults[$feature]);
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