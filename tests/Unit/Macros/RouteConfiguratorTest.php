<?php declare(strict_types=1);

namespace Tests\Unit\Macros;

use Dive\Fez\Macros\RouteConfigurator;
use Dive\Fez\RouteConfig;

beforeEach(function () {
    RouteConfigurator::register();
});

it('accepts a closure/string/null to customize the config', function () {
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

    $route->fez(null);

    expect($route->defaults)->toMatchArray([
        'fez' => [
            'attributes' => [],
            'strategy' => 'null',
        ],
    ]);
});
