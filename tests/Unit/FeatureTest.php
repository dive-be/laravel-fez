<?php declare(strict_types=1);

namespace Tests\Unit;

use Dive\Fez\Feature;
use Illuminate\Support\Facades\Config;

it('can retrieve feature names', function () {
    expect(Feature::alternatePage())->toBe('alternatePage');
    expect(Feature::metaElements())->toBe('metaElements');
    expect(Feature::openGraph())->toBe('openGraph');
    expect(Feature::twitterCards())->toBe('twitterCards');
});

it('can retrieve all features', function () {
    expect(Feature::all())->toBe([
        'alternatePage',
        'metaElements',
        'openGraph',
        'twitterCards',
    ]);
});

it('can retrieve enabled features', function () {
    Config::set('fez.features', [
        'alternatePage',
        'metaElements',
        'metaElements', // duplicate
        'openGraph',
        'twitterCards',
        'schema', // non-existing feature
    ]);

    $enabled = Feature::enabled();

    expect($enabled)->toBe([
        'alternatePage',
        'metaElements',
        'openGraph',
        'twitterCards',
    ]);
});
