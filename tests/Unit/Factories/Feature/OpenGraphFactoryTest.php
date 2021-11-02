<?php declare(strict_types=1);

namespace Tests\Unit\Factories\Feature;

use Dive\Fez\Factories\Feature\OpenGraphFactory;
use Dive\Fez\OpenGraph\Objects\Profile;
use Illuminate\Contracts\Routing\UrlGenerator;
use Mockery;

it('can create a preconfigured rich object instance', function () {
    $url = Mockery::mock(UrlGenerator::class);
    $url->shouldReceive('current')->andReturn('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    $factory = OpenGraphFactory::make('nl', $url);

    $object = $factory->create([
        'alternates' => ['de', 'en'],
        'description' => 'Never Gonna Give You Up',
        'image' => '/static/assets/rick_astley.jpg',
        'locale' => true,
        'site_name' => 'YouTube',
        'type' => 'profile',
        'url' => true,
    ]);

    expect($object)
        ->toBeInstanceOf(Profile::class)
        ->toHaveCount(8)
        ->description->content()->toBe('Never Gonna Give You Up')
        ->locale->content()->toBe('nl')
        ->site_name->content()->toBe('YouTube')
        ->type->content()->toBe('profile')
        ->url->content()->toBe('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    // image & alternate locales are pushable types
    expect($object->components())->toHaveKeys([0, 1, 2]);
});
