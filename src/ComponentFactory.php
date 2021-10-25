<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Exceptions\SorryUnexpectedComponent;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ComponentFactory
{
    private array $defaults;

    private TitleFormatter $formatter;

    private array $locales;

    public function __construct(
        private Application $app,
        private Request $request,
        private UrlGenerator $url,
        Repository $config,
    ) {
        $this->defaults = $config->get('fez.defaults');
        $this->locales = array_unique($config->get('fez.locales'));
        $this->formatter = TitleFormatter::make(
            Arr::pull($this->defaults, 'general.suffix'),
            Arr::pull($this->defaults, 'general.separator'),
        );
    }

    public function make(string $component): Component
    {
        return match ($component) {
            Feature::alternatePage() => $this->alternatePage(),
            Feature::meta() => $this->meta(),
            Feature::openGraph() => $this->openGraph(),
            Feature::twitterCards() => $this->twitterCards(),
            default => throw SorryUnexpectedComponent::make($component),
        };
    }

    private function alternatePage(): AlternatePage
    {
        return AlternatePage::make($this->locales, $this->request);
    }

    private function defaultsFor(string $component): array
    {
        return array_merge($this->defaults['general'], $this->defaults[$component]);
    }

    private function meta(): Meta
    {
        return Meta::make($this->formatter, $this->url, $this->defaultsFor(__FUNCTION__));
    }

    private function openGraph(): OpenGraph
    {
        return OpenGraph::make(
            $this->formatter,
            $this->url,
            $this->app->getLocale(),
            $this->defaultsFor(__FUNCTION__),
        );
    }

    private function twitterCards(): TwitterCards
    {
        return TwitterCards::make($this->formatter, $this->defaultsFor(__FUNCTION__));
    }
}
