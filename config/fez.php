<?php

use Dive\Fez\Fez;

return [
    'defaults' => [
        'general' => [
            'description' => null,
            'image' => null, // Relative path or absolute URL
            'separator' => '|', // Separation symbol used in title generation when a suffix is set
            'suffix' => env('APP_NAME'),
            'title' => null,
        ],

        Fez::FEATURE_META => [
            'canonical' => true, // Uses Url::current when enabled
            'keywords' => null, // An array of default keywords
            'robots' => ['index', 'follow'], // Any valid combination of index/follow, noindex/nofollow or all/none
        ],

        Fez::FEATURE_OPEN_GRAPH => [
            'locale' => true, // Generates locale tag based on the current active app locale
            'site_name' => env('APP_NAME'),
            'type' => 'website',
            'url' => true, // Uses Url::current when enabled
        ],

        Fez::FEATURE_TWITTER_CARDS => [
            'card' => 'summary',
            'site' => null, // Prefix with @ mandatory
        ],
    ],

    /**
     * At least one feature must be enabled. You may leave out features if you don't need them.
     * The order of these features also defines the order in which the tags are generated when rendering your views.
     */
    'features' => [
        Fez::FEATURE_META,
        Fez::FEATURE_OPEN_GRAPH,
        Fez::FEATURE_TWITTER_CARDS,
        // Dive\Fez\Fez::FEATURE_ALTERNATE_PAGES,
    ],

    /**
     * An array of locales the application supports and serves (including the default locale).
     *
     * At least two locales must be provided when using the alternate pages feature.
     */
    'locales' => [],

    /**
     * The fully qualified class names of models that should be used.
     */
    'models' => [
        'meta_data' => Dive\Fez\Models\MetaData::class,
        'static_page' => Dive\Fez\Models\StaticPage::class,
    ],
];
