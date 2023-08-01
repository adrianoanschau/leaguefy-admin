<?php

namespace Leaguefy\LeaguefyAdmin;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

use JeroenNoten\LaravelAdminLte\Http\ViewComposers\AdminLteComposer;

class LeaguefyAdminServiceProvider extends ServiceProvider
{
    private $prefix = 'leaguefy-admin';

    private $middlewares = [
        'leaguefy-admin.pjax'       => Middleware\Pjax::class,
        'leaguefy-admin.redirects'  => Middleware\Redirects::class,
        'leaguefy-admin.inertia'    => Middleware\HandleInertiaRequests::class,
        'leaguefy-admin.inertia-assets' => AddLinkHeadersForPreloadedAssets::class,
    ];

    private $commands = [
        Console\LeaguefyAdminCommand::class,
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

        $this->app->register(LeaguefyAdminConfigProvider::class);
    }

    public function boot(Factory $view)
    {
        $this->loadViewsFrom($this->path(LeaguefyAdmin::$views), $this->prefix);
        $this->loadTranslationsFrom($this->path(LeaguefyAdmin::$translations), $this->prefix);

        Blade::componentNamespace('Leaguefy\\LeaguefyAdmin\\View\\Components', 'leaguefy-admin');
        $this->loadViewComponentsAs('leaguefy-admin', []);

        if ($this->app->runningInConsole()) {
            $this->publishes([$this->path(LeaguefyAdmin::$assets) => public_path("vendor/{$this->prefix}")], "{$this->prefix}-assets");
            $this->loadMigrationsFrom($this->path(LeaguefyAdmin::$migrations));
        }

        $this->app->booted(function () {
            Route::group([
                'prefix'     => config('leaguefy-admin.route.prefix'),
                'middleware' => array_merge([
                        'web',
                        'leaguefy-admin',
                        'leaguefy-admin.pjax',
                        'leaguefy-admin.redirects',
                        'leaguefy-admin.inertia',
                        'leaguefy-admin.inertia-assets',
                    ],
                    config('leaguefy-admin.route.middleware', []),
                    config('leaguefy-manager.route.middleware', []),
                ),
                'as' => 'leaguefy.admin.',
            ], $this->path(LeaguefyAdmin::$routes));
        });

        $this->registerViewComposers($view);
    }

    private function path($path)
    {
        return __DIR__."/../$path";
    }

    private function registerViewComposers(Factory $view)
    {
        $view->composer("{$this->prefix}::page", AdminLteComposer::class);
    }
}
