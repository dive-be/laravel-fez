<?php declare(strict_types=1);

namespace Tests\Unit\Finders;

use Dive\Fez\Factories\FinderFactory;
use Dive\Fez\Finders\SmartFinder;
use Dive\Fez\Models\Route;
use Tests\Fakes\Models\Post;

it('can find a metable by guessing the type of page and thus acting "smart"', function () {
    $post = Post::factory()->make();
    $route = Route::factory()->create(['name' => 'posts.index']);
    $index = createLaravelRoute('posts', name: 'posts.index');
    $detail = createLaravelRoute('posts/{post}', compact('post'), 'posts.show');
    $finder = SmartFinder::make(
        FinderFactory::make(),
        ['model' => $route::class],
    );

    $metableA = $finder->find($index);
    $metableB = $finder->find($detail);

    expect($route->is($metableA))->toBeTrue();
    expect($post->is($metableB))->toBeTrue();
});
