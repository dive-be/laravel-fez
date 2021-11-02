<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph\Objects;

use DateTimeInterface;
use Dive\Fez\OpenGraph\Objects\Book;

beforeEach(function () {
    $this->book = Book::make();
});

it('can set isbn', function () {
    $this->book->isbn('978-3-16-148410-0');

    expect(
        $this->book->isbn->content()
    )->toBe('978-3-16-148410-0');
});

it('can set release date', function () {
    $this->book->releaseDate($date = now());

    expect(
        $this->book->release_date->content()
    )->toBe($date->format(DateTimeInterface::ISO8601));
});
