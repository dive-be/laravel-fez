<?php declare(strict_types=1);

use Dive\Fez\Feature;
use Dive\Fez\Models\Meta;
use Dive\Fez\Models\Route;

return [
    'defaults' => [
        'general' => [
            'description' => null, // Pass an array to localize e.g. ['fr' => 'Salut', 'en' => 'Hello', 'nl' => 'Hallo']
            'image' => null, // Relative path or absolute URL
        ],

        Feature::metaElements() => [
            'canonical' => true, // Uses Url::current when enabled
            'keywords' => null, // Comma separated default keywords
            'robots' => 'index, follow', // Any valid combination of index/follow, noindex/nofollow or all/none
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
     * A (Metable) Finder is responsible for finding a metable object in/by way of an active route
     * which will then be used to fill various features that are enabled.
     */
    'finder' => [
        /**
         * Define the default strategy.
         *
         * Supported values: "null", "relevance"
         */
        'strategy' => 'relevance',
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

    /**
     * Define how your page titles should be formatted here.
     *
     * - Assign null to disable title formatting: 'title' => null
     * - Replace the default formatter with your own: 'title' => App\Formatters\MyTitleFormatter::class
     */
    'title' => [
        'separator' => '|',
        'suffix' => env('APP_NAME'),
    ],
];
