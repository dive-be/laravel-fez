<?php declare(strict_types=1);

namespace Dive\Fez\Http\Middleware;

use Closure;
use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Factories\FinderFactory;
use Dive\Fez\Manager;
use Dive\Fez\RouteConfig;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class LoadFromRoute
{
    public function __construct(
        private Manager $fez,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();

        $metable = $this->createFinder(
            $this->getStrategy($route)
        )->find($route);

        if ($metable instanceof Metable) {
            $this->fez->loadFrom($metable);
        }

        $route->forgetParameter('fez');

        return $next($request);
    }

    private function createFinder(array $strategy): Finder
    {
        return FinderFactory::make()->create(...$strategy);
    }

    private function getStrategy(Route $route): array
    {
        return $route->defaults['fez'] ?? RouteConfig::default()->toArray();
    }
}
