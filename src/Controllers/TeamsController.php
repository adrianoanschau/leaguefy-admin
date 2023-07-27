<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

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

        return view('leaguefy-admin::teams.index', [
            'columns' => [
                [
                    'column' => 'name',
                    'avatar' => 'logo',
                    'subtitle' => 'slug',
                ],
                'slug'
            ],
            'data' => $teams,
        ]);
    }

    public function create()
    {
        return view('leaguefy-admin::teams.form', [
            'fields' => [
                'name',
                [
                    'column' => 'game',
                    'options' => $this->gamesService->list()->pluck('name', 'slug'),
                ],
            ],
        ]);
    }

    public function store(StoreTeamRequest $request)
    {
        $this->teamsService->store($request);

        return redirect()->route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Time criado com sucesso!']
        ]));
    }

    public function edit(string $id)
    {
        $data = $this->teamsService->find($id);

        return view('leaguefy-admin::teams.form', [
            'id' => $id,
            'fields' => [
                'name',
                [
                    'label' => 'Game',
                    'column' => 'game.name',
                    'disabled' => true,
                ]
            ],
            'data' => $data,
        ]);
    }

    public function update(string $id, UpdateTeamRequest $request)
    {
        $this->teamsService->update($id, $request);

        return redirect()->route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Time atualizado com sucesso!']
        ]));
    }

    public function destroy(string $id)
    {
        $this->teamsService->destroy($id);

        return redirect()->route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Time excluído com sucesso!']
        ]));
    }

}
