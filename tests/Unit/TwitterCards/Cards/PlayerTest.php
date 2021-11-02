<?php declare(strict_types=1);

namespace Tests\Unit\TwitterCards\Cards;

use Dive\Fez\TwitterCards\Cards\Player;

beforeEach(function () {
    $this->card = Player::make();
});

it('can set height', function () {
    expect(
        $this->card->height(1337)
    )->{'player:height'}->content()->toBe('1337');
});

it('can set url', function () {
    expect(
        $this->card->url('https://videoplayer.com')
    )->player->content()->toBe('https://videoplayer.com');
});

it('can set width', function () {
    expect(
        $this->card->width(1337)
    )->{'player:width'}->content()->toBe('1337');
});
