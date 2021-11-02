<?php declare(strict_types=1);

namespace Tests\Unit\TwitterCards\Cards;

use Dive\Fez\TwitterCards\Cards\SummaryLargeImage;

it('can set creator', function () {
    expect(
        SummaryLargeImage::make()->creator('Rick Astley')
    )->creator->content()->toBe('Rick Astley');
});
