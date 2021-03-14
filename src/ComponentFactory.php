<?php

namespace Dive\Fez;

use Dive\Fez\Containers\Meta;
use Dive\Fez\Containers\OpenGraph;
use Dive\Fez\Containers\Schema;
use Dive\Fez\Containers\TwitterCards;
use Dive\Fez\Exceptions\UnexpectedComponentException;
use Dive\Fez\Localization\AlternatePage;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class ComponentFactory
{
    public function __construct(private Repository $config, private Request $request) {}

    public function make(string $component): Component
    {
        return match ($component) {
            'alternatePages' => AlternatePage::make(array_unique($this->config->get('fez.locales')), $this->request),
            'meta' => Meta::make(),
            'openGraph' => OpenGraph::make(),
            'schemaOrg' => Schema::make(),
            'twitterCards' => TwitterCards::make(),
            default => throw UnexpectedComponentException::make($component),
        };
    }
}
