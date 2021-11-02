<?php declare(strict_types=1);

namespace Tests\Unit;

use Dive\Fez\TwitterCards;
use Dive\Fez\TwitterCards\Cards\Player;
use Dive\Fez\TwitterCards\Cards\Summary;
use Dive\Fez\TwitterCards\Cards\SummaryLargeImage;

it('instantiates a player object', function () {
    expect(
        TwitterCards::player()
    )->toBeInstanceOf(Player::class);
});

it('instantiates a summary object', function () {
    expect(
        TwitterCards::summary()
    )->toBeInstanceOf(Summary::class);
});

it('instantiates a summary large image object', function () {
    expect(
        TwitterCards::summaryLargeImage()
    )->toBeInstanceOf(SummaryLargeImage::class);
});
