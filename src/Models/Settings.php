<?php

namespace Leaguefy\LeaguefyAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public $hidden = [
        'id',
    ];

    public $fillable = [
        'name',
        'value',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('leaguefy-admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('leaguefy-admin.database.tables.settings'));

        parent::__construct($attributes);
    }
}
