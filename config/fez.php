<?php

return [
    'defaults' => [
        'description' => env('FEZ_DEFAULTS_DESCRIPTION'),
        'image' => env('FEZ_DEFAULTS_IMAGE'),
        'keywords' => array_filter(explode(',', env('FEZ_DEFAULTS_KEYWORDS'))),
        'robots' => env('FEZ_DEFAULTS_ROBOTS', 'index, follow'),
        'separator' => env('FEZ_DEFAULTS_SEPARATOR', ' | '),
        'suffixed' => true,
        'title' => env('FEZ_DEFAULTS_TITLE'),
    ],

    'locales' => [],
];
