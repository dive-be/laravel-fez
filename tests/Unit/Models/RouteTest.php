<?php declare(strict_types=1);

namespace Tests\Unit\Models;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Models\Concerns\HasMetaData;
use Dive\Fez\Models\Route;

it('is metable', function () {
    $route = new Route();

    expect($route)->toBeInstanceOf(Metable::class);
    expect(class_uses($route))->toContain(HasMetaData::class);
});
