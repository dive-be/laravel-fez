<?php declare(strict_types=1);

namespace Tests\Unit;

use Dive\Fez\OpenGraph;
use Dive\Fez\OpenGraph\Objects\Article;
use Dive\Fez\OpenGraph\Objects\Book;
use Dive\Fez\OpenGraph\Objects\Profile;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\OpenGraph\Properties\Image;
use Dive\Fez\OpenGraph\Properties\Video;

it('instantiates an article object', function () {
    expect(
        OpenGraph::article()
    )->toBeInstanceOf(Article::class);
});

it('instantiates an audio object', function () {
    expect(
        OpenGraph::audio()
    )->toBeInstanceOf(Audio::class);
});

it('instantiates a book object', function () {
    expect(
        OpenGraph::book()
    )->toBeInstanceOf(Book::class);
});

it('instantiates an image object', function () {
    expect(
        OpenGraph::image()
    )->toBeInstanceOf(Image::class);
});

it('instantiates a profile object', function () {
    expect(
        OpenGraph::profile()
    )->toBeInstanceOf(Profile::class);
});

it('instantiates a video object', function () {
    expect(
        OpenGraph::video()
    )->toBeInstanceOf(Video::class);
});

it('instantiates a website object', function () {
    expect(
        OpenGraph::website()
    )->toBeInstanceOf(Website::class);
});
