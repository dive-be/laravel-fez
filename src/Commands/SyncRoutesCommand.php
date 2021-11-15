<?php declare(strict_types=1);

namespace Dive\Fez\Commands;

use Illuminate\Console\Command;

class SyncRoutesCommand extends Command
{
    protected $description = 'Synchronize database routes with route definitions.';

    protected $signature = 'fez:sync';

    public function handle(): int
    {
        $this->callSilently('fez:seed');
        $this->callSilently('fez:prune');

        $this->info('🔄  Route syncing completed successfully.');

        return self::SUCCESS;
    }
}
