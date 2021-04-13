<?php

namespace Dive\Fez;

use Dive\Fez\Exceptions\UnexpectedComponentException;
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
            Fez::FEATURE_ALTERNATE_PAGE => $this->alternatePage(),
            Fez::FEATURE_META => $this->meta(),
            Fez::FEATURE_OPEN_GRAPH => $this->openGraph(),
            Fez::FEATURE_TWITTER_CARDS => $this->twitterCards(),
            default => throw UnexpectedComponentException::make($component),
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
        return Meta::make($this->formatter, $this->url, $this->defaultsFor(Fez::FEATURE_META));
    }

    private function openGraph(): OpenGraph
    {
        return OpenGraph::make(
            $this->formatter,
            $this->url,
            $this->app->getLocale(),
            $this->defaultsFor(Fez::FEATURE_OPEN_GRAPH),
        );
    }

    private function twitterCards(): TwitterCards
    {
        return TwitterCards::make($this->formatter, $this->defaultsFor(Fez::FEATURE_TWITTER_CARDS));
    }
}
