<?php

namespace Leaguefy\LeaguefyAdmin\Facades;

use Illuminate\Support\Facades\Facade;

class LeaguefyAdmin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leaguefy\LeaguefyAdmin\LeaguefyAdmin::class;
    }
}
