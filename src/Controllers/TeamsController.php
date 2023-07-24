<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Illuminate\Http\Request;
use Leaguefy\LeaguefyManager\Services\GamesService;
use Leaguefy\LeaguefyManager\Services\TeamsService;

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

    public function store(Request $request)
    {
        try {
            $this->teamsService->store($request);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Time criado com sucesso!']
        ]));
    }

    public function edit(int $id)
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

    public function update(int $id, Request $request)
    {
        try {
            $this->teamsService->update($id, $request);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Time atualizado com sucesso!']
        ]));
    }

    public function destroy(int $id)
    {
        try {
            $this->teamsService->destroy($id);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.teams.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Time excluído com sucesso!']
        ]));
    }

}
