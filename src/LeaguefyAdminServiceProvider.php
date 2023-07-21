<?php

namespace Leaguefy\LeaguefyAdmin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

use JeroenNoten\LaravelAdminLte\Http\ViewComposers\AdminLteComposer;

class LeaguefyAdminServiceProvider extends ServiceProvider
{
    private $prefix = 'leaguefy-admin';

    private $middlewares = [
        'leaguefy-admin.pjax' => Middleware\Pjax::class,
    ];

    private $commands = [
        Console\LeaguefyCommand::class,
        Console\InstallCommand::class,
    ];

    public function register()
    {
        foreach ($this->middlewares as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        app('router')->aliasMiddleware('leaguefy-admin', function ($request, $next) {
            $this->loadTranslationsFrom($this->path(LeaguefyAdmin::$translations), 'adminlte');

            return $next($request);
        });

        $this->commands($this->commands);
    }

    public function boot(Factory $view)
    {
        $this->loadViewsFrom($this->path(LeaguefyAdmin::$views), $this->prefix);
        $this->loadTranslationsFrom($this->path(LeaguefyAdmin::$translations), $this->prefix);
        $this->mergeConfigFrom($this->path(LeaguefyAdmin::$config_file), $this->prefix);

        Blade::componentNamespace('Leaguefy\\LeaguefyAdmin\\View\\Components', 'leaguefy-admin');
        $this->loadViewComponentsAs('leaguefy-admin', []);

        if ($this->app->runningInConsole()) {
            $this->publishes([$this->path(LeaguefyAdmin::$assets) => public_path("vendor/{$this->prefix}")], "{$this->prefix}-assets");
            // $this->publishes([$this->path(LeaguefyAdmin::$config_path) => config_path()], 'leaguefy-admin');
            // $this->loadMigrationsFrom(LeaguefyAdmin::migrations);
        }

        $this->app->booted(function () {
            Route::group([
                'prefix'     => config('leaguefy-admin.route.prefix'),
                'middleware' => array_merge(['leaguefy-admin', 'leaguefy-admin.pjax'], config('leaguefy-admin.route.middleware', [])),
            ], $this->path(LeaguefyAdmin::$routes));
        });

        $this->overrideAdminLteConfig();
        $this->registerViewComposers($view);
    }

    private function path($path)
    {
        return __DIR__."/../$path";
    }
    private function overrideAdminLteConfig()
    {
        $adminlte = config('adminlte', []);
        $leaguefyAdmin = config('leaguefy-admin', []);

        collect($adminlte)->map(function ($value, $index) {
            if (!config("leaguefy-admin.{$index}")) {
                Config::set("leaguefy-admin.{$index}", config("adminlte.{$index}"));
            }
        });

        collect($leaguefyAdmin)->map(function ($value, $index) {
            Config::set("adminlte.{$index}", config("leaguefy-admin.{$index}", config("adminlte.{$index}")));
        });
    }

    private function registerViewComposers(Factory $view)
    {
        $view->composer('leaguefy-admin::page', AdminLteComposer::class);
    }
}
