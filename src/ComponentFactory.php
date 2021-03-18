<?php

namespace Dive\Fez;

use Dive\Fez\Containers\Meta;
use Dive\Fez\Containers\OpenGraph;
use Dive\Fez\Containers\TwitterCards;
use Dive\Fez\Exceptions\UnexpectedComponentException;
use Dive\Fez\Localization\AlternatePages;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;

class ComponentFactory
{
    private array $defaults;

    private array $locales;

    public function __construct(
        private Request $request,
        private UrlGenerator $url,
        Repository $config,
    ) {
        $this->defaults = $config->get('fez.defaults');
        $this->locales = $config->get('fez.locales');
    }

    public function make(string $component): Component
    {
        return match ($component) {
            Fez::FEATURE_ALTERNATE_PAGES => AlternatePages::make(array_unique($this->locales), $this->request),
            Fez::FEATURE_META => Meta::make($this->url, $this->defaultsFor(Fez::FEATURE_META)),
            Fez::FEATURE_OPEN_GRAPH => OpenGraph::make($this->url, $this->defaultsFor(Fez::FEATURE_OPEN_GRAPH)),
            Fez::FEATURE_TWITTER_CARDS => TwitterCards::make($this->defaultsFor(Fez::FEATURE_TWITTER_CARDS)),
            default => throw UnexpectedComponentException::make($component),
        };
    }

    private function defaultsFor(string $component): array
    {
        return array_merge($this->defaults['general'], $this->defaults[$component]);
    }
}
