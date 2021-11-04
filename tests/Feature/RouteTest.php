<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\Fakes\Models\Post;

beforeEach(function () {
    Route::get('posts/{post}', static function (Post $post) {
        return view('test::tree', compact('post'));
    })->middleware('web');

    $this->post = Post::factory()->create();
    $this->post->meta()->create([
        'description' => 'Taylor is not the hero we need but the hero we deserve',
        'title' => 'Taylor Otwell saves the PHP ecosystem',
    ]);
});

test('model can be found using a strategy and utilized as hydration source for fez')
    ->get('posts/1')
    ->assertOk()
    ->assertSee('<title>Taylor Otwell saves the PHP ecosystem | Laravel Fez</title>', false)
    ->assertSee('<meta name="description" content="Taylor is not the hero we need but the hero we deserve" />', false)
    ->assertSee('<meta property="og:title" content="Taylor Otwell saves the PHP ecosystem | Laravel Fez" />', false)
    ->assertSee('<meta property="og:description" content="Taylor is not the hero we need but the hero we deserve" />', false)
    ->assertSee('<meta name="twitter:title" content="Taylor Otwell saves the PHP ecosystem | Laravel Fez" />', false)
    ->assertSee('<meta name="twitter:description" content="Taylor is not the hero we need but the hero we deserve" />', false);
