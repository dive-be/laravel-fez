<?php declare(strict_types=1);

namespace Dive\Fez\Middleware;

use Closure;
use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Factories\FinderFactory;
use Dive\Fez\FezManager;
use Dive\Fez\RouteConfig;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;

class HydrateFromParameters
{
    public function __construct(
        private FezManager $fez,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();

        if (is_null($route)) {
            return $next($request);
        }

        $metable = $this->createFinder(
            $this->getStrategy($route)
        )->find($route);

        if ($metable instanceof Metable) {
            $this->fez->for($metable);
        }

        return $next($request);
    }

    private function createFinder(array $strategy): Finder
    {
        return FinderFactory::make()->create(...$strategy);
    }

    private function getStrategy(Route $route): array
    {
        return Arr::pull($route->defaults, 'fez') ?? RouteConfig::default()->toArray();
    }
}
