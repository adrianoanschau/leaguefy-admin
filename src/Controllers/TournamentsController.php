<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Leaguefy\LeaguefyManager\Services\TournamentsService;

class TournamentsController extends Controller
{
    public function __construct(
        private TournamentsService $tournamentsService,
    ) {}

    public function index()
    {
        $tournaments = $this->tournamentsService->list();

        return view('leaguefy-admin::tournaments.index', [
            'columns' => [
                ['label' => 'Name', 'column' => 'name'],
            ],
            'data' => $tournaments->toArray(),
        ]);
    }

}
