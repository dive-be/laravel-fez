<?php declare(strict_types=1);

namespace Tests\Integration;

use function Pest\Laravel\mock;

it('proxies call to the manager', function () {
    $view = view('welcome');

    mock('fez')
        ->shouldReceive('set')
        ->once()
        ->withArgs(fn ($property, $value) => $property === 'title' && $value === 'Never Gonna Give You Up');

    $result = $view->fez('title', 'Never Gonna Give You Up');

    expect($result)->toBe($view);
});
