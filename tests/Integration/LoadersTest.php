<?php declare(strict_types=1);

namespace Tests\Integration;

use Dive\Fez\Feature;
use Dive\Fez\Loaders\DescriptionLoader;
use Dive\Fez\Loaders\ImageLoader;
use Dive\Fez\Loaders\MetaElementsLoader;
use Dive\Fez\Loaders\OpenGraphLoader;
use Dive\Fez\Loaders\TitleLoader;
use Dive\Fez\Loaders\TwitterCardsLoader;
use Dive\Fez\MetaData;
use Dive\Fez\MetaElements;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\TwitterCards\Cards\Summary;
use Tests\Fakes\Models\Post;
use Tests\Fakes\RickRollFormatter;

it('loads twitter', function () {
    $manager = createFez([Feature::twitterCards() => Summary::make()]);
    $loader = new TwitterCardsLoader();
    $card = Summary::make()
        ->title('Rick Astley')
        ->description('Never Gonna Give You Up')
        ->image('/static/assets/img/rick_astley.jpg')
        ->toArray();

    expect($manager->twitterCards)->toHaveCount(1);

    $loader->load($manager, MetaData::make(twitter: $card));

    expect($manager->twitterCards->toArray())->toMatchArray($card);
});

it('loads titles', function () {
    $loader = new TitleLoader(new RickRollFormatter());
    $manager = createFez();

    expect($manager->roll->title)->toBeNull();

    $loader->load($manager, MetaData::make(title: 'Pest'));

    expect(
        $manager->roll->title->value()
    )->toBe('Never Gonna Give You Up, Pest!');
});

it('loads open graph', function () {
    $manager = createFez([Feature::openGraph() => Website::make()]);
    $loader = new OpenGraphLoader();
    $object = Website::make()
        ->title('Rick Astley')
        ->description('Never Gonna Give You Up')
        ->image('/static/assets/img/rick_astley.jpg')
        ->audio(Audio::make()->secureUrl('https://soundcloud.com'))
        ->toArray();

    expect($manager->openGraph)->toHaveCount(1);

    $loader->load($manager, MetaData::make(open_graph: $object));

    expect($manager->openGraph->toArray())->toMatchArray($object);
});

it('loads meta elements', function () {
    $manager = createFez([Feature::metaElements() => MetaElements::make()]);
    $loader = new MetaElementsLoader();
    $elements = MetaElements::make()
        ->keywords('rick, roll')
        ->robots('index, follow')
        ->toArray();

    expect($manager->metaElements)->toHaveCount(0);

    $loader->load($manager, MetaData::make(elements: $elements));

    expect($manager->metaElements->toArray())->toMatchArray($elements);
});

it('loads images', function () {
    $loader = new ImageLoader();
    $manager = createFez();

    expect($manager->roll->image)->toBeNull();

    $loader->load($manager, MetaData::make(image: '/static/assets/img/rick_astley.jpg'));

    expect(
        $manager->roll->image->value()
    )->toBe('/static/assets/img/rick_astley.jpg');
});

it('loads descriptions', function () {
    $loader = new DescriptionLoader();
    $manager = createFez();

    expect($manager->roll->description)->toBeNull();

    $loader->load($manager, MetaData::make(description: 'Never Gonna Give You Up'));

    expect(
        $manager->roll->description->value()
    )->toBe('Never Gonna Give You Up');
});

it('can load the features using a metable model', function () {
    $manager = createFez();

    expect($manager->model())->toBeNull();

    $manager->loadFrom($post = Post::factory()->make());

    expect($manager->model())->toBe($post);
});

it('can __call and "set" a property', function () {
    $manager = createFez();

    $manager->title('Rick Astley');

    expect(
        $manager->roll->title->value()
    )->toBe('Rick Astley | Laravel Fez');
});

it('can __set a property', function () {
    $manager = createFez();

    expect($manager->roll->description)->toBeNull();

    $manager->description = 'Never Gonna Give You Up';

    expect(
        $manager->roll->description->value()
    )->toBe('Never Gonna Give You Up');
});

it('can automagically "set" properties', function () {
    $manager = createFez();

    expect($manager->roll->description)->toBeNull();
    expect($manager->roll->image)->toBeNull();
    expect($manager->roll->title)->toBeNull();

    $manager->set([
        'description' => 'Never Gonna Give You Up',
        'image' => '/static/assets/img/rick_astley.jpg',
        'title' => 'Rick Astley',
    ]);

    expect(
        $manager->roll->description->value()
    )->toBe('Never Gonna Give You Up');

    expect(
        $manager->roll->image->value()
    )->toBe('/static/assets/img/rick_astley.jpg');

    expect(
        $manager->roll->title->value()
    )->toBe('Rick Astley | Laravel Fez');
});
