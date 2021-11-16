<?php declare(strict_types=1);

namespace Dive\Fez\Commands;

use Dive\Fez\Support\WithRoutes;
use Illuminate\Console\Command;

class PruneRoutesCommand extends Command
{
    use WithRoutes;

    protected $description = 'Prune defunct route models.';

    protected $signature = 'fez:prune';

    public function handle(): int
    {
        $routes = $this
            ->newQuery()
            ->whereNotIn('id', $this->getRouteIds())
            ->get();

        if ($routes->isEmpty()) {
            $this->error('🤚  There are no routes that should be pruned.');

            return self::FAILURE;
        }

        $this->withProgressBar($routes, static fn ($route) => $route->prune());

        $this->line('');
        $this->info("🔥  Successfully pruned {$routes->count()} route(s).");

        return self::SUCCESS;
    }
}
