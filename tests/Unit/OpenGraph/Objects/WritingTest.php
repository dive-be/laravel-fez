<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph\Objects;

use Dive\Fez\OpenGraph\Objects\Book;

beforeEach(function () {
    $this->writing = Book::make();
});

it('can push author', function () {
    $this->writing->author('Rick Astley')->author('Muhammed Sari');

    expect($this->writing)
        ->toHaveCount(3) // + type
        ->get(0)->name()->toBe('author')
        ->get(0)->content()->toBe('Rick Astley')
        ->get(1)->name()->toBe('author')
        ->get(1)->content()->toBe('Muhammed Sari');
});

it('can push tag', function () {
    $this->writing->tag('rick')->tag('roll');

    expect($this->writing)
        ->toHaveCount(3) // + type
        ->get(0)->name()->toBe('tag')
        ->get(0)->content()->toBe('rick')
        ->get(1)->name()->toBe('tag')
        ->get(1)->content()->toBe('roll');
});
