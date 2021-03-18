<?php

namespace Dive\Fez;

use Dive\Fez\Containers\Meta;
use Dive\Fez\Containers\OpenGraph;
use Dive\Fez\Containers\TwitterCards;
use Dive\Fez\Exceptions\UnexpectedComponentException;
use Dive\Fez\Localization\AlternatePages;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class ComponentFactory
{
    public function __construct(private Repository $config, private Request $request) {}

    public function make(string $component): Component
    {
        return match ($component) {
            'alternatePages' => AlternatePages::make(array_unique($this->config->get('fez.locales')), $this->request),
            'meta' => Meta::make($this->config->get('fez.defaults')),
            'openGraph' => OpenGraph::make(),
            'twitterCards' => TwitterCards::make(),
            default => throw UnexpectedComponentException::make($component),
        };
    }
}
