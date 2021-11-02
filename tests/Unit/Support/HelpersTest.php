<?php declare(strict_types=1);

namespace Tests\Unit\Support;

use Dive\Fez\Feature;

test('alternate', function () {
    config([
        'fez.features' => [Feature::alternatePage()],
        'fez.locales' => ['de', 'en'],
    ]);

    expect(
        alternate()
    )->toBe(
        resolve('fez')->get(Feature::alternatePage())
    );
});

test('fez', function () {
    config([
        'fez.features' => [Feature::openGraph()],
    ]);

    // no args
    expect(
        fez()
    )->toBe(
        resolve('fez')
    );

    // string args
    expect(
        fez(Feature::openGraph())
    )->toBe(
        resolve('fez')->get(Feature::openGraph())
    );

    // array args
    expect(fez(Feature::openGraph()))
        ->description->toBeNull()
        ->image->toBeNull()
        ->title->toBeNull();

    fez([
        'description' => 'Never Gonna Give You Up',
    ]);

    expect(fez(Feature::openGraph()))
        ->description->content()->toBe('Never Gonna Give You Up');
});

test('og', function () {
    // no args
    expect(
        og()
    )->toBe(
        resolve('fez')->get(Feature::openGraph())
    );

    // string args
    expect(
        og('type')
    )->toBe(
        og()->get('type')
    );
});

test('twitter', function () {
    // no args
    expect(
        twitter()
    )->toBe(
        resolve('fez')->get(Feature::twitterCards())
    );

    // string args
    expect(
        twitter('card')
    )->toBe(
        twitter()->get('card')
    );
});
