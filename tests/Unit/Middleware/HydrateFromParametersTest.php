<?php declare(strict_types=1);

namespace Tests\Unit\Middleware;

use Dive\Fez\FezManager;
use Dive\Fez\Middleware\HydrateFromParameters;
use Illuminate\Http\Request;
use Mockery;
use Tests\Fakes\Models\Post;

it('skips execution if there is no route', function () {
    $fez = Mockery::mock(FezManager::class);
    $fez->shouldNotReceive('for');
    $middleware = new HydrateFromParameters($fez);

    $middleware->handle(new Request(), function () {});
});

it('can find a metable and hydrate various features', function () {
    $post = Post::factory()->make();
    $request = (new Request())->setRouteResolver(fn () => createLaravelRoute('posts/{post}', ['post' => $post]));
    $middleware = new HydrateFromParameters($fez = Mockery::spy(FezManager::class));

    $response = $middleware->handle($request, fn () => 'success');

    expect($response)->toBe('success');
    $fez->shouldHaveReceived('for')->withArgs([$post]);
});
