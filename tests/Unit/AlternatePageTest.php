<?php declare(strict_types=1);

namespace Tests\Unit;

use Dive\Fez\AlternatePage;
use Dive\Fez\Exceptions\SorryTooFewLocalesSpecified;
use Dive\Fez\Exceptions\SorryUnspecifiedUrlResolver;
use Illuminate\Http\Request;

afterEach(function () {
    AlternatePage::urlUsing(null);
});

it('cannot be instantiated if passed locales are too few', function () {
    createAlternatePage(['tr']);
})->throws(SorryTooFewLocalesSpecified::class);

it('must have a url resolver to render', function () {
    $alternatePage = createAlternatePage();

    AlternatePage::urlUsing(null);

    $alternatePage->render();
})->throws(SorryUnspecifiedUrlResolver::class);

it('is arrayable', function () {
    expect(
        createAlternatePage()->toArray()
    )->toMatchArray([
        'en' => 'https://dive.be/en',
        'nl' => 'https://dive.be/nl',
    ]);
});

it('is renderable', function () {
    expect(
        createAlternatePage()->render()
    )->toBe(
        '<link rel="alternate" href="https://dive.be/en" hreflang="en" />' . PHP_EOL .
        '<link rel="alternate" href="https://dive.be/nl" hreflang="nl" />'
    );
});

function createAlternatePage(array $locales = ['en', 'nl']): AlternatePage
{
    AlternatePage::urlUsing(static function (string $locale, Request $request) {
        return $request->getUri() . $locale;
    });

    return AlternatePage::make($locales, Request::create('https://dive.be'));
}
