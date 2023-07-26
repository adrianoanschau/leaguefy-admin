<?php

namespace Leaguefy\LeaguefyAdmin\Repositories;

use Illuminate\Support\Facades\Schema;
use Leaguefy\LeaguefyAdmin\Models\Settings;

class SettingsRepository extends BaseRepository
{
    protected static $model = Settings::class;

    public function exists()
    {
        return Schema::hasTable(app(static::$model)->getTable());
    }
}
