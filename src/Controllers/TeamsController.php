<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Inertia\Inertia;
use Leaguefy\LeaguefyManager\Services\GamesService;
use Leaguefy\LeaguefyManager\Services\TeamsService;
use Leaguefy\LeaguefyManager\Requests\StoreTeamRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateTeamRequest;

class TeamsController extends Controller
{
    public function __construct(
        private TeamsService $teamsService,
        private GamesService $gamesService,
    ) {}

    public function index()
    {
        $teams = $this->teamsService->list();

        return Inertia::render('Teams/List', [
            'data' => $teams,
            'games' => $this->gamesService->list()->pluck('name', 'slug'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Teams/Form', [
            'games' => $this->gamesService->list()->pluck('name', 'slug'),
        ]);
    }

    public function store(StoreTeamRequest $request)
    {
        $this->teamsService->store($request);

        return to_route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => 'success',
            'message' => 'Time criado com sucesso!',
        ]));
    }

    public function edit(string $id)
    {
        $data = $this->teamsService->find($id)->load(['game']);

        return Inertia::render('Teams/Form', [
            'id' => $id,
            'games' => $this->gamesService->list()->pluck('name', 'slug'),
            'data' => $data,
        ]);
    }

    public function update(string $id, UpdateTeamRequest $request)
    {
        $this->teamsService->update($id, $request);

        return to_route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => 'success',
            'message' => 'Time atualizado com sucesso!',
        ]));
    }

    public function destroy(string $id)
    {
        $this->teamsService->destroy($id);

        return to_route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => 'success',
            'message' => 'Time excluído com sucesso!',
        ]));
    }

}
