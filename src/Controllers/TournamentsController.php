<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Illuminate\Http\Request;
use Leaguefy\LeaguefyManager\Services\GamesService;
use Leaguefy\LeaguefyManager\Services\TournamentsService;

class TournamentsController extends Controller
{
    public function __construct(
        private TournamentsService $tournamentsService,
        private GamesService $gamesService,
    ) {}

    public function index()
    {
        $tournaments = $this->tournamentsService->list();

        return view('leaguefy-admin::tournaments.index', [
            'columns' => [
                [
                    'column' => 'name',
                    'avatar' => 'logo',
                    'subtitle' => 'slug',
                ],
                'slug',
                [
                    'label' => 'Stages',
                    'classes' => 'text-center',
                    'link_route' => 'stages',
                    'link_icon' => 'fa-cogs',
                ],
            ],
            'data' => $tournaments,
        ]);
    }

    public function create()
    {
        return view('leaguefy-admin::tournaments.form', [
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
            $this->tournamentsService->store($request);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.tournaments.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Torneio criado com sucesso!']
        ]));
    }

    public function edit(int $id)
    {
        $data = $this->tournamentsService->find($id);

        return view('leaguefy-admin::tournaments.form', [
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

    public function update(int $id, Request $request)
    {
        try {
            $this->tournamentsService->update($id, $request);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.tournaments.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Torneio atualizado com sucesso!']
        ]));
    }

    public function destroy(int $id)
    {
        try {
            $this->tournamentsService->destroy($id);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.tournaments.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Torneio excluído com sucesso!']
        ]));
    }

}
