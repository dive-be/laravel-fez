<?php

namespace Dive\Fez;

use Dive\Fez\Exceptions\NoFeaturesActiveException;
use ReflectionClass;

final class Fez extends Component
{
    public const FEATURE_ALTERNATE_PAGES = 'alternatePages';
    public const FEATURE_META = 'meta';
    public const FEATURE_OPEN_GRAPH = 'openGraph';
    public const FEATURE_SCHEMA_ORG = 'schemaOrg';
    public const FEATURE_TWITTER_CARDS = 'twitterCards';

    private array $components;

    public function __construct(array $features, ComponentFactory $factory)
    {
        $this->components = $this->initialize($features, $factory);
    }

    public function generate(): string
    {
        return '';
    }

    public function toArray(): array
    {
        return [];
    }

    /**
     * @throws NoFeaturesActiveException
     */
    private function initialize(array $features, ComponentFactory $factory): array
    {
        $features = array_intersect($features, (new ReflectionClass(self::class))->getConstants());

        if (empty($features)) {
            throw NoFeaturesActiveException::make();
        }

        return array_combine($features, array_map([$factory, 'make'], $features));
    }
}
