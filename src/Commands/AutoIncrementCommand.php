<?php declare(strict_types=1);

namespace Dive\Fez\Commands;

use Dive\Fez\Support\WithRoutes;
use Illuminate\Console\Command;

class AutoIncrementCommand extends Command
{
    use WithRoutes;

    protected $description = 'Determine the starting AI identifier that can be used safely in route definitions.';

    protected $signature = 'fez:id';

    public function handle(): int
    {
        $next = $this->newQuery()->max('id') + 1;

        $this->line("💡  You should use <fg=green>{$next}</> as your starting auto-increment id.");

        return self::SUCCESS;
    }
}
