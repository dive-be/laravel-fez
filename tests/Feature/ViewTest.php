<?php declare(strict_types=1);

namespace Tests\Feature;

use Dive\Fez\Facades\Fez;

beforeEach(function () {
    Fez::metaElements()->title('Santa Claus saves the winter');
    Fez::twitterCards()->title('Nuno Maduro saves the testing ecosystem');
    Fez::openGraph()->title('Taylor Otwell saves the PHP ecosystem');
});

test('fez can be rendered fully', function () {
    $this
        ->view('test::tree')
        ->assertSee('<title>Santa Claus saves the winter</title>', false)
        ->assertSee('<meta name="twitter:title" content="Nuno Maduro saves the testing ecosystem" />', false)
        ->assertSee('<meta property="og:title" content="Taylor Otwell saves the PHP ecosystem" />', false);
});

test('fez can be rendered partially', function () {
    $this
        ->view('test::branches')
        ->assertDontSee('Santa Claus saves the winter')
        ->assertSee('<meta name="twitter:title" content="Nuno Maduro saves the testing ecosystem" />', false)
        ->assertDontSee('Taylor Otwell saves the PHP ecosystem');
});
