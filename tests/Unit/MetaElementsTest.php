<?php declare(strict_types=1);

namespace Tests\Unit;

use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\MetaElements;
use Dive\Fez\MetaElements\Canonical;
use Dive\Fez\MetaElements\Element;

beforeEach(function () {
    $this->el = MetaElements::make();
});

it('is describable', function () {
    $this->el->description('Never Gonna Give You Up');

    expect($this->el)
        ->toBeInstanceOf(Describable::class)
        ->toHaveCount(1)
        ->description->content()->toBe('Never Gonna Give You Up');
});

it('is titleable', function () {
    $this->el->title('Never Gonna Give You Up');

    expect($this->el)
        ->toBeInstanceOf(Titleable::class)
        ->toHaveCount(1)
        ->title->value()->toBe('Never Gonna Give You Up');
});

it('can set a canonical url', function () {
    $this->el->canonical('https://dive.be');

    expect($this->el->canonical)
        ->toBeInstanceOf(Canonical::class)
        ->url()->toBe('https://dive.be');
});

it('can set keywords', function () {
    $this->el->keywords('rick, roll');

    expect($this->el->keywords)
        ->toBeInstanceOf(Element::class)
        ->content()->toBe('rick, roll');
});

it('can set robots', function () {
    $this->el->robots('noindex, nofollow');

    expect($this->el->robots)
        ->toBeInstanceOf(Element::class)
        ->content()->toBe('noindex, nofollow');
});
