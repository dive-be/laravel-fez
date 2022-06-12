<?php declare(strict_types=1);

namespace Tests\Unit\Finders;

use Dive\Fez\Finders\RelevanceFinder;
use Tests\Fakes\Models\Post;
use Tests\Fakes\Models\User;

it('can find a metable via its order in the route signature', function () {
    $post = Post::factory()->make();
    $route = createLaravelRoute('users/{user}/posts/{post}', [
        'user' => User::factory()->make(),
        'post' => $post,
    ]);

    $metable = RelevanceFinder::make()->find($route);

    expect($metable->is($post))->toBeTrue();
});
