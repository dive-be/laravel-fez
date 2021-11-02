<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph;

use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\OpenGraph\Properties\Image;
use Dive\Fez\OpenGraph\Property;

beforeEach(function () {
    $this->object = Website::make(); // Website is 1-to-1 equal to a RichObject without any additional behavior
});

it('is arrayable', function () {
    expect(
        $this->object->toArray()
    )->toMatchArray([
        'properties' => [
            [
                'attributes' => [
                    'content' => 'website',
                    'name' => 'type',
                ],
                'type' => 'property',
            ],
        ],
        'type' => 'website',
    ]);
});

it('is describable', function () {
    $this->object->description('Never Gonna Give You Up');

    expect($this->object)
        ->toBeInstanceOf(Describable::class)
        ->description->content()->toBe('Never Gonna Give You Up');
});

it('is imageable', function () {
    $this->object
        ->image('/static/assets/img/rick_astley.jpg')
        ->image(Image::make()->secureUrl('/static/assets/img/rick_astley2.jpg'));

    expect($this->object)
        ->toBeInstanceOf(Imageable::class)
        ->get(0)->content()->toBe('/static/assets/img/rick_astley.jpg');

    expect($this->object->get(1))
        ->toBeInstanceOf(Image::class)
        ->image->content()->toBe('/static/assets/img/rick_astley2.jpg');
});

it('is titleable', function () {
    $this->object->title('Rick Astley');

    expect($this->object)
        ->toBeInstanceOf(Titleable::class)
        ->title->content()->toBe('Rick Astley');
});

it('can push alternate locales', function () {
    $this->object
        ->alternateLocale('cn')
        ->alternateLocale(['de', 'fr']);

    expect($this->object->get(0))
        ->name()->toBe('locale:alternate')
        ->content()->toBe('cn');

    expect($this->object->get(1))
        ->name()->toBe('locale:alternate')
        ->content()->toBe('de');

    expect($this->object->get(2))
        ->name()->toBe('locale:alternate')
        ->content()->toBe('fr');
});

it('can push audio', function () {
    $this->object
        ->audio('https://www.youtube.com/watch?v=dQw4w9WgXcQ')
        ->audio(Audio::make()->secureUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ'));

    expect($this->object->get(0))
        ->name()->toBe('audio')
        ->content()->toBe('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    expect($this->object->get(1))
        ->toBeInstanceOf(Audio::class)
        ->audio->content()->toBe('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
});

it('can set determiner', function () {
    $this->object->determiner('auto');

    expect($this->object->determiner)->content()->toBe('auto');
});

it('can set locale', function () {
    $this->object->locale('tr');

    expect($this->object->locale)->content()->toBe('tr');
});

it('can set url', function () {
    $this->object->url('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    expect($this->object->url)->content()->toBe('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
});

it('can set site name', function () {
    $this->object->siteName('DIVE');

    expect($this->object->site_name)->content()->toBe('DIVE');
});

it('can get the type', function () {
    expect($this->object->type())->toBe('website');
});

it('can push a property', function () {
    $this->object->pushProperty('rick', 'astley');

    expect($this->object->get(0))
        ->toBeInstanceOf(Property::class)
        ->name()->toBe('rick')
        ->content()->toBe('astley');
});

it('can set a property', function () {
    $this->object->setProperty('rick', 'astley');

    expect($this->object->get('rick'))
        ->toBeInstanceOf(Property::class)
        ->content()->toBe('astley');
});
