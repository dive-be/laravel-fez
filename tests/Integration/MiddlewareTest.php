<?php declare(strict_types=1);

namespace Tests\Integration;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Events\MetableWasFound;
use Dive\Fez\Http\Middleware\LoadFromRoute;
use Dive\Fez\Manager;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Tests\Fakes\Models\Post;
use function Pest\Laravel\get;
use function Pest\Laravel\mock;

it('can find a metable and load all features with meta data', function () {
    Route::get('posts/{post}', fn (Post $post) => $post->toArray())
        ->fez('binding', 'post')
        ->middleware([SubstituteBindings::class, LoadFromRoute::class]);

    Event::fake(MetableWasFound::class);

    $post = Post::factory()->create();

    mock(Manager::class)
        ->shouldReceive('loadFrom')
        ->withArgs(static fn (Post $model) => $model->is($post))
        ->once();

    get("posts/{$post->getKey()}")->assertOk();

    expect(app(Metable::class))->toBeInstanceOf(Post::class);

    Event::assertDispatched(MetableWasFound::class);
});

it('skips execution if there is no route', function () {
    Route::get('posts', fn (Post $post) => 'Hola Mundo')->middleware('fez');

    mock(Manager::class)->shouldNotReceive('loadFrom');

    get('posts')->assertOk();
});
