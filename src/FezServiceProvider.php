<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Commands\InstallPackageCommand;
use Dive\Fez\Contracts\Route as RouteContract;
use Dive\Fez\Exceptions\SorryNoFeaturesActive;
use Dive\Fez\Factories\FeatureFactory;
use Dive\Fez\Macros\RouteMacro;
use Dive\Fez\Macros\ViewMacro;
use Dive\Fez\Models\Route as RouteModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class FezServiceProvider extends ServiceProvider
{
    private array $macros = [
        RouteMacro::class,
        ViewMacro::class,
    ];

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->registerConfig();
            $this->registerMigration();
        }

        $this->registerBladeDirectives();
        $this->registerMacros();
        $this->registerMorphMap();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fez.php', 'fez');

        $this->registerDefaultRouteKeyResolver();
        $this->registerManager();
        $this->registerRouteModel();
    }

    private function registerBladeDirectives()
    {
        $this->app->afterResolving('blade.compiler', static function (BladeCompiler $blade) {
            $blade->directive('fez', static fn (string $expression) => "<?php echo e(fez({$expression})) . PHP_EOL ?>");
        });
    }

    private function registerCommands()
    {
        $this->commands([
            InstallPackageCommand::class,
        ]);
    }

    private function registerConfig()
    {
        $config = 'fez.php';

        $this->publishes([
            __DIR__ . '/../config/' . $config => $this->app->configPath($config),
        ], 'config');
    }

    private function registerDefaultRouteKeyResolver()
    {
        RouteModel::keyUsing(static fn ($route) => $route->getName());
    }

    private function registerManager()
    {
        $this->app->singleton('fez', static function (Application $app) {
            if (empty($features = Feature::enabled())) {
                throw SorryNoFeaturesActive::make();
            }

            $factory = FeatureFactory::make($app['config']['fez'])
                ->setLocaleResolver(static fn () => $app->getLocale())
                ->setRequestResolver(static fn () => $app['request'])
                ->setUrlResolver(static fn () => $app['url']);

            return new Fez(
                array_combine($features, array_map([$factory, 'create'], $features))
            );
        });

        $this->app->alias('fez', Fez::class);
    }

    private function registerMacros()
    {
        foreach ($this->macros as $macro) {
            call_user_func([$macro, 'register']);
        }
    }

    private function registerMigration()
    {
        $migration = 'create_fez_tables.php';
        $doesntExist = Collection::make(glob($this->app->databasePath('migrations/*.php')))
            ->every(fn ($filename) => ! str_ends_with($filename, $migration));

        if ($doesntExist) {
            $timestamp = date('Y_m_d_His', time());
            $stub = __DIR__ . "/../database/migrations/{$migration}.stub";

            $this->publishes([
                $stub => $this->app->databasePath("migrations/{$timestamp}_{$migration}"),
            ], 'migrations');
        }
    }

    private function registerMorphMap()
    {
        Relation::morphMap($this->app['config']['fez.models']);
    }

    private function registerRouteModel()
    {
        $this->app->alias(RouteContract::class, $model = $this->app['config']['fez.models.route']);

        $this->app->bind(RouteContract::class, static function (Application $app) use ($model) {
            return call_user_func([$model, 'resolve'], $app['router']->getCurrentRoute());
        });
    }
}
