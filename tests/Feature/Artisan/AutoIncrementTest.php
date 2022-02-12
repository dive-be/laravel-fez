<?php declare(strict_types=1);

namespace Tests\Feature\Artisan;

use Dive\Fez\Database\Factories\RouteFactory;
use Illuminate\Console\Command;
use function Pest\Laravel\artisan;

it('tells the next AI id that should be used', function () {
    artisan('fez:id')
        ->assertExitCode(Command::SUCCESS)
        ->expectsOutput('💡  You should use 1 as your starting auto-increment id.');

    RouteFactory::times(3)->create();

    artisan('fez:id')
        ->assertExitCode(Command::SUCCESS)
        ->expectsOutput('💡  You should use 4 as your starting auto-increment id.');
});
