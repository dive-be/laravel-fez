<?php declare(strict_types=1);

namespace Tests\Unit\Finders;

use Dive\Fez\Finders\BindingFinder;
use Tests\Fakes\Models\Post;

it('can find a metable using a fixed binding', function () {
    $post = Post::factory()->make();
    $route = createLaravelRoute('posts/{post}', compact('post'));

    $metable = BindingFinder::make('post')->find($route);

    expect($post->is($metable))->toBeTrue();
});
