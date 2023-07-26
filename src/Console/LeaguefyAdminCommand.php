<?php

namespace Leaguefy\LeaguefyAdmin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Leaguefy\LeaguefyAdmin\LeaguefyAdmin;

class LeaguefyAdminCommand extends Command
{
    protected $signature = 'leaguefy-admin';

    protected $description = 'List LeaguefyAdmin commands';

    public static $logo = <<<LOGO
    __                                ____
   / /   ___  ____ _____ ___  _____  / __/_  __
  / /   / _ \/ __ `/ __ `/ / / / _ \/ /_/ / / /
 / /___/  __/ /_/ / /_/ / /_/ /  __/ __/ /_/ /
/_____/\___/\__,_/\__, /\__,_/\___/_/  \__, /
                 /____/               /____/
                                   ::Admin::

LOGO;

    public function handle()
    {
        $this->line("<fg=red>" . static::$logo . "</>");
        $this->line(LeaguefyAdmin::getLongVersion());

        $this->comment('');
        $this->comment('Available commands:');

        $this->listLeaguefyAdminCommands();
    }

    private function listLeaguefyAdminCommands()
    {
        $commands = collect(Artisan::all())->mapWithKeys(function ($command, $key) {
            if (Str::startsWith($key, 'leaguefy-admin:')) {
                return [$key => $command];
            }

            return [];
        })->toArray();

        $width = $this->getColumnWidth($commands);

        /** @var Command $command */
        foreach ($commands as $command) {
            $this->line(sprintf(" %-{$width}s %s", $command->getName(), $command->getDescription()));
        }
    }

    private function getColumnWidth(array $commands)
    {
        $widths = [];

        foreach ($commands as $command) {
            $widths[] = static::strlen($command->getName());
            foreach ($command->getAliases() as $alias) {
                $widths[] = static::strlen($alias);
            }
        }

        return $widths ? max($widths) + 2 : 0;
    }

    public static function strlen($string)
    {
        if (false === $encoding = mb_detect_encoding($string, null, true)) {
            return strlen($string);
        }

        return mb_strwidth($string, $encoding);
    }
}
