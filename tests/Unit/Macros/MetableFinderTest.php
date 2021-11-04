<?php declare(strict_types=1);

namespace Tests\Unit\Macros;

use Dive\Fez\Macros\MetableFinder;
use Tests\Fakes\Models\Post;

beforeEach(function () {
    MetableFinder::register();
});

it('can find a metable using the configured strategy', function () {
    $post = Post::factory()->make();
    $route = createLaravelRoute('posts/{post}', compact('post'));

    // No route defined config: use default strategy
    expect($route->metable()->is($post))->toBeTrue();

    // Route defined config
    $route->defaults('fez', [
        'attributes' => [
            'parameterName' => 'post',
        ],
        'strategy' => 'binding',
    ]);

    expect($route->metable()->is($post))->toBeTrue();
});
