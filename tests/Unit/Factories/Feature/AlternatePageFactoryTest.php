<?php declare(strict_types=1);

namespace Tests\Unit\Factories\Feature;

use Dive\Fez\AlternatePage;
use Dive\Fez\Factories\Feature\AlternatePageFactory;
use Illuminate\Http\Request;

it('can create alternate page instances', function (array $locales) {
    $factory = AlternatePageFactory::make(new Request());

    $alternatePage = $factory->create($locales);

    expect($alternatePage)
        ->toBeInstanceOf(AlternatePage::class)
        ->locales()->toBe($locales);
})->with([
    [['de', 'en']],
    [['fr', 'nl']],
]);
