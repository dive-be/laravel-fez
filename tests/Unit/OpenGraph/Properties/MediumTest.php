<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph\Properties;

use Dive\Fez\OpenGraph\Properties\Audio;

beforeEach(function () {
    $this->prop = Audio::make();
});

it('can set mime type', function () {
    $this->prop->mime('audio/mp3');

    expect($this->prop->get('audio:type'))
        ->content()->toBe('audio/mp3');
});

it('can set secure url', function () {
    $this->prop->secureUrl('https://dive.be');

    expect($this->prop)
        ->get('audio')->content()->toBe('https://dive.be')
        ->get('audio:secure_url')->content()->toBe('https://dive.be');

    $this->prop->url('https://facebook.com', true); // proxies to above method

    expect($this->prop)
        ->get('audio')->content()->toBe('https://facebook.com')
        ->get('audio:secure_url')->content()->toBe('https://facebook.com');
});

it('can set "unsecure" url', function () {
    $this->prop->url('https://dive.be');

    expect($this->prop)
        ->get('audio')->content()->toBe('https://dive.be')
        ->get('audio:url')->content()->toBe('https://dive.be');
});
