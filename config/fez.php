<?php

use Dive\Fez\Feature;
use Dive\Fez\Models\Meta;
use Dive\Fez\Models\Route;

return [
    'defaults' => [
        'general' => [
            'description' => null,
            'image' => null, // Relative path or absolute URL
            'separator' => '|', // Separation symbol used in title generation when a suffix is set
            'suffix' => env('APP_NAME'),
            'title' => null,
        ],

        Feature::metaElements() => [
            'canonical' => true, // Uses Url::current when enabled
            'keywords' => null, // An array of default keywords
            'robots' => ['index', 'follow'], // Any valid combination of index/follow, noindex/nofollow or all/none
        ],

        Feature::openGraph() => [
            'locale' => true, // Generates locale tag based on the current active app locale
            'site_name' => env('APP_NAME'),
            'type' => 'website', // article, book, profile or website
            'url' => true, // Uses Url::current when enabled
        ],

        Feature::twitterCards() => [
            'site' => null, // Prefix with @ mandatory
            'type' => 'summary', // summary, summary_large_image or player
        ],
    ],

    /**
     * At least one feature must be enabled. You may leave out features if you don't need them.
     * The order of these features also defines the order in which the tags are generated when rendering your views.
     */
    'features' => [
        Feature::metaElements(),
        Feature::openGraph(),
        Feature::twitterCards(),
        // Feature::alternatePage(),
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
        'meta' => Meta::class,
        'route' => Route::class,
    ],
];
