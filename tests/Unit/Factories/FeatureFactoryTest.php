<?php declare(strict_types=1);

namespace Tests\Unit\Factories;

use Dive\Fez\AlternatePage;
use Dive\Fez\Factories\FeatureFactory;
use Dive\Fez\Feature;
use Dive\Fez\MetaElements;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\TwitterCards\Cards\Summary;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Mockery;

it('can create an alternate page component', function () {
    $factory = createFactory(['locales' => ['tr', 'ru']]);

    $component = $factory->create(Feature::alternatePage());

    expect($component)
        ->toBeInstanceOf(AlternatePage::class)
        ->locales()->toMatchArray(['tr', 'ru']);
});

it('can create a meta elements component', function () {
    $factory = createFactory();

    $component = $factory->create(Feature::metaElements());

    expect($component)
        ->toBeInstanceOf(MetaElements::class)
        ->description->toBeNull()
        ->canonical->url()->toBe('https://dive.be')
        ->keywords->toBeNull()
        ->robots->content()->toBe('index, follow');
});

it('can create an open graph component', function () {
    $factory = createFactory();

    $component = $factory->create(Feature::openGraph());

    expect($component)
        ->toBeInstanceOf(Website::class)
        ->image->toBeNull()
        ->description->toBeNull()
        ->site_name->content()->toBe('Laravel Fez')
        ->url->content()->toBe('https://dive.be')
        ->locale->content()->toBe('tr');
});

it('can create a twitter cards component', function () {
    $factory = createFactory();

    $component = $factory->create(Feature::twitterCards());

    expect($component)
        ->toBeInstanceOf(Summary::class)
        ->image->toBeNull()
        ->description->toBeNull()
        ->site->toBeNull();
});

it('can extract localized string from description and use that', function () {
    $factory = createFactory([
        'defaults' => [
            'general' => [
                'description' => [
                    'en' => 'Never Gonna Give You Up',
                    'tr' => 'Senden asla vazgeçmeyeceğim',
                ],
            ],
        ],
    ]);

    $components = array_map([$factory, 'create'], [
        Feature::metaElements(),
        Feature::openGraph(),
        Feature::twitterCards(),
    ]);

    expect($components)->each(fn ($component) => $component
        ->description
        ->content()
        ->toBe('Senden asla vazgeçmeyeceğim')
    );
});

function createFactory(array $override = []): FeatureFactory
{
    $config = require __DIR__ . '/../../../config/fez.php';
    $url = Mockery::mock(UrlGenerator::class);
    $url->shouldReceive('current')->andReturn('https://dive.be');

    return FeatureFactory::make(array_merge_recursive($config, $override))
        ->setLocaleResolver(static fn () => 'tr')
        ->setRequestResolver(static fn () => new Request())
        ->setUrlResolver(static fn () => $url);
}
