<?php declare(strict_types=1);

namespace Tests\Feature\Artisan;

use Illuminate\Console\Command;
use function Pest\Laravel\artisan;

it('can sync route definitions with route models', function () {
    artisan('fez:sync')
        ->assertExitCode(Command::SUCCESS)
        ->expectsOutput('🔄  Route syncing completed successfully.');
});
