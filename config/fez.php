<?php

return [
    'defaults' => [
        'description' => null,
        'image' => null,
        'keywords' => null,
        'robots' => 'index, follow',
        'separator' => '|',
        'suffix' => null,
        'title' => null,
    ],

    'features' => [
        Dive\Fez\Fez::FEATURE_META,
        Dive\Fez\Fez::FEATURE_OPEN_GRAPH,
        Dive\Fez\Fez::FEATURE_TWITTER_CARDS,
        Dive\Fez\Fez::FEATURE_SCHEMA_ORG,
        Dive\Fez\Fez::FEATURE_ALTERNATE_PAGES,
    ],

    'locales' => [],

    'models' => [
        'meta_data' => Dive\Fez\Models\MetaData::class,
        'static_page' => Dive\Fez\Models\StaticPage::class,
    ],
];
