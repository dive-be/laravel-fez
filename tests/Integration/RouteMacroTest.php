<?php declare(strict_types=1);

namespace Tests\Integration;

use Dive\Fez\RouteConfig;

it('accepts a closure/string/bool to customize the config', function () {
    $route = createLaravelRoute('posts/{post}');

    $route->fez(fn (RouteConfig $config) => $config->binding('post'));

    expect($route->defaults)->toMatchArray([
        'fez' => [
            'attributes' => [
                'parameterName' => 'post',
            ],
            'strategy' => 'binding',
        ],
    ]);

    $route->fez('relevance');

    expect($route->defaults)->toMatchArray([
        'fez' => [
            'attributes' => [],
            'strategy' => 'relevance',
        ],
    ]);

    $route->fez(false);

    expect($route->defaults)->toMatchArray([
        'fez' => [
            'attributes' => [],
            'strategy' => 'null',
        ],
    ]);
});
