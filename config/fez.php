<?php

return [

    /**
     * App-wide defaults. Overwritten if models provide their own defaults.
     */
    'defaults' => [
        'description' => null,
        'image' => null, // Link to a static asset
        'keywords' => null, // An array of default keywords
        'robots' => ['index', 'follow'], // Any valid combination of index/follow noindex/nofollow or all/none
        'separator' => '|', // Separation symbol used in title generation when a suffix is set
        'suffix' => null,
        'title' => null,
    ],

    /**
     * At least one feature must be enabled. You may leave out features if you don't need it.
     * The order of these features also defines the order in which the tags are generated when rendering your views.
     */
    'features' => [
        Dive\Fez\Fez::FEATURE_META,
        Dive\Fez\Fez::FEATURE_OPEN_GRAPH,
        Dive\Fez\Fez::FEATURE_TWITTER_CARDS,
        // Dive\Fez\Fez::FEATURE_ALTERNATE_PAGES,
    ],

    /**
     * An array of locales that should be used when generating alternate page tags.
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
