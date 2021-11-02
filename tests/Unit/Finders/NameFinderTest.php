<?php declare(strict_types=1);

namespace Tests\Unit\Finders;

use Dive\Fez\Database\Factories\RouteFactory;
use Dive\Fez\Finders\NameFinder;
use Illuminate\Support\Str;

it('can find a metable route (model) using a route name', function () {
    NameFinder::transformNameUsing(fn (string $name) => Str::after($name, '.'));

    $route = createLaravelRoute('posts', name: 'en.posts.index');
    $model = RouteFactory::new()->create(['name' => 'posts.index']);

    $metable = NameFinder::make()->find($route);

    expect($model->is($metable))->toBeTrue();

    NameFinder::transformNameUsing(null);
});
