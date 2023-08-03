<?php

namespace Leaguefy\LeaguefyAdmin;

class LeaguefyAdmin
{
    public const VERSION = '0.1.23';

    public static $config_path = 'config';

    public static $config_file = 'config/leaguefy-admin.php';

    public static $migrations = 'database/migrations';

    public static $routes = 'routes/web.php';

    public static $views = 'resources/views';

    public static $translations = 'resources/lang';

    public static $assets = 'resources/assets';

    public static function getLongVersion()
    {
        return sprintf('Leaguefy Admin <comment>version</comment> <info>%s</info>', self::VERSION);
    }

}
