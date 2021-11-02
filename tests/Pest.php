<?php declare(strict_types=1);

use Dive\Fez\FezManager;
use Illuminate\Container\Container;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Routing\Route;
use Tests\Fakes\Components\RickRollComponent;
use Tests\Fakes\Components\RickRollContainer;
use Tests\TestCase;

uses(TestCase::class)->in(__DIR__);
uses(InteractsWithViews::class)->in('Feature');

function createLaravelRoute(string $uri, array $parameters = [], string $name = 'default'): Route
{
    $route = new Route('GET', $uri, function () {});
    $route->parameters = array_keys($parameters);
    $route->parameterNames();
    $route->name($name);
    $route->setContainer(Container::getInstance());

    foreach ($parameters as $name => $value) {
        $route->setParameter($name, $value);
    }

    return $route;
}

function createFez(array $config = [], ?array $features = null): FezManager
{
    return FezManager::make($config,
        $features ?? ['rick' => RickRollComponent::make(), 'roll' => RickRollContainer::make()]
    );
}
