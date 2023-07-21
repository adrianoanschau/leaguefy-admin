<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Leaguefy\LeaguefyManager\Services\TeamsService;

class TeamsController extends Controller
{
    public function __construct(
        private TeamsService $teamsService,
    ) {}

    public function index()
    {
        $teams = $this->teamsService->list();

        return view('leaguefy-admin::teams.index', [
            'columns' => [
                ['label' => 'Name', 'column' => 'name'],
            ],
            'data' => $teams->toArray(),
        ]);
    }

}
