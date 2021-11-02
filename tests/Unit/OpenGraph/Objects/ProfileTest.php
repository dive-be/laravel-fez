<?php declare(strict_types=1);

namespace Tests\Unit\OpenGraph\Objects;

use Dive\Fez\OpenGraph\Objects\Profile;

beforeEach(function () {
    $this->profile = Profile::make();
});

it('can set first name', function () {
    $this->profile->firstName('Rick');

    expect(
        $this->profile->first_name->content()
    )->toBe('Rick');
});

it('can set gender', function () {
    $this->profile->gender('male');

    expect(
        $this->profile->gender->content()
    )->toBe('male');
});

it('can set last name', function () {
    $this->profile->lastName('Astley');

    expect(
        $this->profile->last_name->content()
    )->toBe('Astley');
});

it('can set username', function () {
    $this->profile->username('RickastleyCoUkOfficial');

    expect(
        $this->profile->username->content()
    )->toBe('RickastleyCoUkOfficial');
});
