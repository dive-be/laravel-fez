<?php declare(strict_types=1);

namespace Tests\Unit\Factories;

use Dive\Fez\Exceptions\SorryUnknownTwitterCardsType;
use Dive\Fez\Factories\CardFactory;
use Dive\Fez\TwitterCards\Cards\Player;
use Dive\Fez\TwitterCards\Cards\Summary;
use Dive\Fez\TwitterCards\Cards\SummaryLargeImage;

it('creates the correct card for the given type', function (string $type, string $class) {
   expect(CardFactory::make()->create($type))->toBeInstanceOf($class);
})->with([
    ['player', Player::class],
    ['summary', Summary::class],
    ['summary_large_image', SummaryLargeImage::class],
]);

it('throws if an unknown type is given', function () {
    CardFactory::make()->create('Never Gonna Give You Up');
})->throws(SorryUnknownTwitterCardsType::class);
