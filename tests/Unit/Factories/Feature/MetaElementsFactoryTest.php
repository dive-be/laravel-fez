<?php declare(strict_types=1);

namespace Tests\Unit\Factories\Feature;

use Dive\Fez\Factories\Feature\MetaElementsFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Mockery;

it('can create a preconfigured meta elements instance', function () {
    $url = Mockery::mock(UrlGenerator::class);
    $url->shouldReceive('current')->once()->andReturn('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    $factory = MetaElementsFactory::make($url);

    $elements = $factory->create([
        'canonical' => true,
        'description' => 'Never Gonna Give You Up',
        'keywords' => 'rick, roll',
        'robots' => 'noindex, nofollow',
    ]);

    expect($elements)
        ->toHaveCount(4)
        ->canonical->url()->toBe('https://www.youtube.com/watch?v=dQw4w9WgXcQ')
        ->description->content()->toBe('Never Gonna Give You Up')
        ->keywords->content()->toBe('rick, roll')
        ->robots->content()->toBe('noindex, nofollow');
});
