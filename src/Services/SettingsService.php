<?php

namespace Leaguefy\LeaguefyAdmin\Services;

use Leaguefy\LeaguefyAdmin\Repositories\SettingsRepository;

class SettingsService
{
    public function __construct(
        private SettingsRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function set($name, $value)
    {
        return $this->repository->updateOrCreate(
            ['name' => $name],
            ['value' => $value]
        );
    }

}
