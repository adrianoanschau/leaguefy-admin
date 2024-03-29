<?php

namespace Leaguefy\LeaguefyAdmin;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Leaguefy\LeaguefyAdmin\Repositories\SettingsRepository;

class LeaguefyAdminConfigProvider extends ServiceProvider
{
    private $prefix = 'leaguefy-admin';

    private SettingsRepository $settingsRepository;

    public function __construct(
        $app,
    ) {
        parent::__construct($app);

        $this->settingsRepository = new SettingsRepository();
    }

    public function boot()
    {
        $this->mergeConfigFrom($this->path(LeaguefyAdmin::$config_file), $this->prefix);

        $adminlte = config('adminlte', []);
        $leaguefyAdmin = config($this->prefix, []);

        collect($adminlte)->map(function ($value, $index) {
            if (!config()->has("{$this->prefix}.{$index}")) {
                Config::set("{$this->prefix}.{$index}", config("adminlte.{$index}"));
            }
        });

        collect($leaguefyAdmin)->map(function ($value, $index) {
            Config::set("adminlte.{$index}", config("{$this->prefix}.{$index}", config("adminlte.{$index}")));
        });

        if ($this->settingsRepository->exists()) {
            Config::set('leaguefy-admin.settings.sidebar', true);
            $customPreferences = $this->settingsRepository->all()->pluck('value', 'name');
            $customPreferences->map(function ($value, $index) {
                Config::set("{$this->prefix}.".str_replace("-", ".", $index), $value);
            });
        } else {
            Config::set('leaguefy-admin.settings.sidebar', false);
        }
    }

    private function path($path)
    {
        return __DIR__."/../$path";
    }

}
