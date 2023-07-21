<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Leaguefy\LeaguefyManager\Services\GamesService;

class GamesController extends Controller
{
    public function __construct(
        private GamesService $gamesService,
    ) {}

    public function index()
    {
        $games = $this->gamesService->list();

        return view('leaguefy-admin::games.index', [
            'columns' => [
                'name',
                'slug',
            ],
            'data' => $games->toArray(),
        ]);
    }

}
