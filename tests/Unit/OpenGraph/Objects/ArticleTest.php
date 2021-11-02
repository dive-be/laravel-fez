<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph\Objects;

use DateTimeInterface;
use Dive\Fez\OpenGraph\Objects\Article;

beforeEach(function () {
    $this->article = Article::make();
});

it('can set section', function () {
    $this->article->section('Politics');

    expect(
        $this->article->section->content()
    )->toBe('Politics');
});

it('can set expiration time', function () {
    $this->article->expirationTime($date = now());

    expect(
        $this->article->expiration_time->content()
    )->toBe($date->format(DateTimeInterface::ISO8601));
});

it('can set modified time', function () {
    $this->article->modifiedTime($date = now());

    expect(
        $this->article->modified_time->content()
    )->toBe($date->format(DateTimeInterface::ISO8601));
});

it('can set published time', function () {
    $this->article->publishedTime($date = now());

    expect(
        $this->article->published_time->content()
    )->toBe($date->format(DateTimeInterface::ISO8601));
});
