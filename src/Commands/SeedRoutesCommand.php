<?php declare(strict_types=1);

namespace Dive\Fez\Commands;

use Dive\Fez\Support\WithRoutes;
use Illuminate\Console\Command;

class SeedRoutesCommand extends Command
{
    use WithRoutes;

    protected $description = 'Seed route models declared in route definitions.';

    protected $signature = 'fez:seed';

    public function handle(): int
    {
        $routes = $this->getRouteIds();

        if ($routes->isEmpty()) {
            $this->error('🤚  There are no routes that should be seeded.');

            return self::FAILURE;
        }

        $count = $this
            ->newQuery()
            ->toBase()
            ->upsert($routes->map(static fn (int $id) => compact('id'))->all(), 'id');

        if ($count) {
            $this->info("🤙  Successfully seeded {$count} route(s).");
        } else {
            $this->line('🤷  No new routes were seeded.');
        }

        return self::SUCCESS;
    }
}
