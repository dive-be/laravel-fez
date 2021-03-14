<?php

return [
    'allowed_defaults' => [
        'description',
        'image',
        'keywords',
        'robots',
        'title',
    ],

    'defaults' => [
        'description' => env('FEZ_DEFAULTS_DESCRIPTION'),
        'image' => env('FEZ_DEFAULTS_IMAGE'),
        'keywords' => array_filter(explode(',', env('FEZ_DEFAULTS_KEYWORDS'))),
        'robots' => env('FEZ_DEFAULTS_ROBOTS', 'index, follow'),
        'separator' => env('FEZ_DEFAULTS_SEPARATOR', ' | '),
        'suffixed' => true,
        'title' => env('FEZ_DEFAULTS_TITLE'),
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
