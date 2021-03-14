<?php

namespace Dive\Fez;

final class Fez extends Composite
{
    public const FEATURE_ALTERNATE_PAGES = 'alternatePages';
    public const FEATURE_META = 'meta';
    public const FEATURE_OPEN_GRAPH = 'openGraph';
    public const FEATURE_SCHEMA_ORG = 'schemaOrg';
    public const FEATURE_TWITTER_CARDS = 'twitterCards';

    public function generate(): string
    {
        return '';
    }

    public function toArray(): array
    {
        return [];
    }
}
