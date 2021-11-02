<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph\Properties;

use Dive\Fez\OpenGraph\Properties\Video;

beforeEach(function () {
    $this->prop = Video::make();
});

it('can set alt text', function () {
    $this->prop->alt('Never Gonna Give You Up');

    expect(
        $this->prop->get('video:alt')->content()
    )->toBe('Never Gonna Give You Up');
});

it('can set height', function () {
    $this->prop->height(1337);

    expect(
        $this->prop->get('video:height')->content()
    )->toBe('1337');
});

it('can set width', function () {
    $this->prop->width(1337);

    expect(
        $this->prop->get('video:width')->content()
    )->toBe('1337');
});
