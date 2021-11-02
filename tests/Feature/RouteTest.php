<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\Fakes\Models\Post;
use function Pest\Laravel\get;

beforeEach(function () {
    Route::get('posts/{post}', static function (Post $post) {
        return view('test::tree', compact('post'));
    })->middleware('web');
});

test('model can be found using a strategy and utilized as hydration source for fez', function () {
    $post = Post::factory()->create();
    $post->meta->fill([
        'description' => 'Taylor is not the hero we need but the hero we deserve',
        'title' => 'Taylor Otwell saves the PHP ecosystem',
    ]);
    $post->push();

    get("posts/{$post->getKey()}")
        ->assertOk()
        ->assertSee('<title>Taylor Otwell saves the PHP ecosystem | Laravel Fez</title>', false)
        ->assertSee('<meta name="description" content="Taylor is not the hero we need but the hero we deserve" />', false)
        ->assertSee('<meta property="og:title" content="Taylor Otwell saves the PHP ecosystem | Laravel Fez" />', false)
        ->assertSee('<meta property="og:description" content="Taylor is not the hero we need but the hero we deserve" />', false)
        ->assertSee('<meta name="twitter:title" content="Taylor Otwell saves the PHP ecosystem | Laravel Fez" />', false)
        ->assertSee('<meta name="twitter:description" content="Taylor is not the hero we need but the hero we deserve" />', false);
});
