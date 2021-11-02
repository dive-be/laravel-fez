<?php declare(strict_types=1);

namespace Tests\Unit\Macros;

use Dive\Fez\Macros\MetableFinder;
use Dive\Fez\Models\Route;
use Tests\Fakes\Models\Post;
use function Pest\Laravel\mock;

beforeEach(function () {
    MetableFinder::register();
});

it('can find a metable using the configured strategy', function () {
    $post = Post::factory()->make();
    $route = createLaravelRoute('posts/{post}', compact('post'), $name = 'posts.index');
    $model = Route::factory()->create(compact('name'));

    // No route defined config: use default strategy
    mock('fez')
        ->shouldReceive('config')
        ->once()
        ->with('finder')
        ->andReturn(['strategy' => 'name']);

    expect($route->metable()->is($model))->toBeTrue();

    // Route defined config
    $route->defaults('fez', [
        'attributes' => [
            'parameterName' => 'post',
        ],
        'strategy' => 'binding',
    ]);

    expect($route->metable()->is($post))->toBeTrue();
});
