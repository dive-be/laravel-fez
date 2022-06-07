<?php declare(strict_types=1);

namespace Dive\Fez\Http\Middleware;

use Closure;
use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\MetableNotFoundException;
use Dive\Fez\Factories\FinderFactory;
use Dive\Fez\Manager;
use Dive\Fez\RouteConfig;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class LoadFromRoute
{
    public function __construct(
        private Manager $fez,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $finder = $this->createFinder($route = $request->route());

        try {
            $this->fez->loadFrom($metable = $finder->find($route));

            $this->share($metable);
        } catch (MetableNotFoundException) {
            // noop
        }

        $route->forgetParameter('fez');

        return $next($request);
    }

    private function createFinder(Route $route): Finder
    {
        $strategy = $route->defaults['fez'] ?? RouteConfig::default()->toArray();

        return FinderFactory::make()->create(...$strategy);
    }

    private function share(Metable $metable)
    {
        Container::getInstance()->instance(Metable::class, $metable);
    }
}
