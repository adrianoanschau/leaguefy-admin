<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Inertia\Inertia;
use Leaguefy\LeaguefyManager\Services\GamesService;
use Leaguefy\LeaguefyManager\Services\TournamentsService;
use Leaguefy\LeaguefyManager\Requests\StoreTournamentRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateTournamentRequest;

class TournamentsController extends Controller
{
    public function __construct(
        private TournamentsService $tournamentsService,
        private GamesService $gamesService,
    ) {}

    public function index()
    {
        $tournaments = $this->tournamentsService->list();

        return Inertia::render('Tournaments/List', [
            'columns' => [
                [
                    'column' => 'name',
                    'avatar' => 'logo',
                    'subtitle' => 'slug',
                ],
                'slug',
                [
                    'column' => 'status',
                    'badge' => 'primary',
                ],
                [
                    'label' => 'Stages',
                    'classes' => 'text-center',
                    'link_route' => 'stages',
                    'link_icon' => 'fa-sitemap',
                ],
            ],
            'data' => $tournaments,
        ]);
    }

    public function create()
    {
        return Inertia::render('Tournaments/Form', [
            'fields' => [
                'name',
                [
                    'column' => 'game',
                    'options' => $this->gamesService->list()->pluck('name', 'slug'),
                ],
            ],
        ]);
    }

    public function store(StoreTournamentRequest $request)
    {
        $this->tournamentsService->store($request);

        return to_route("leaguefy.admin.tournaments.index")->with('toastr', collect([
            'type' => 'success',
            'message' => 'Torneio criado com sucesso!',
        ]));
    }

    public function edit(string $id)
    {
        $data = $this->tournamentsService->find($id)->load(['game']);

        return Inertia::render('Tournaments/Form', [
            'id' => $id,
            'fields' => [
                'name',
                [
                    'label' => 'Game',
                    'column' => 'game.name',
                    'disabled' => true,
                ],
            ],
            'data' => $data,
        ]);
    }

    public function update(string $id, UpdateTournamentRequest $request)
    {
        $this->tournamentsService->update($id, $request);

        return to_route("leaguefy.admin.tournaments.index")->with('toastr', collect([
            'type' => 'success',
            'message' => 'Torneio atualizado com sucesso!',
        ]));
    }

    public function destroy(string $id)
    {
        $this->tournamentsService->destroy($id);

        return to_route("leaguefy.admin.tournaments.index")->with('toastr', collect([
            'type' => 'success',
            'message' => 'Torneio excluído com sucesso!',
        ]));
    }

}
