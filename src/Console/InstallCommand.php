<?php

namespace Leaguefy\LeaguefyAdmin\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'leaguefy-admin:install';

    protected $description = 'Install LeaguefyAdmin package';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Leaguefy\LeaguefyAdmin\LeaguefyAdminServiceProvider',
        ]);

        $this->call('leaguefy-manager:install');

        $this->call('adminlte:install');
    }
}
