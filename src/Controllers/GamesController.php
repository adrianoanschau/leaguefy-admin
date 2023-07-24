<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Illuminate\Http\Request;
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
                [
                    'column' => 'name',
                    'avatar' => 'logo',
                    'subtitle' => 'slug',
                ],
                'slug'
            ],
            'data' => $games,
        ]);
    }

    public function create()
    {
        return view('leaguefy-admin::games.form', [
            'fields' => [
                'name',
            ],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->gamesService->store($request);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.games.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Game criado com sucesso!']
        ]));
    }

    public function edit(int $id)
    {
        $data = $this->gamesService->find($id);

        return view('leaguefy-admin::games.form', [
            'id' => $id,
            'fields' => [
                'name',
            ],
            'data' => $data,
        ]);
    }

    public function update(int $id, Request $request)
    {
        try {
            $this->gamesService->update($id, $request);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.games.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Game atualizado com sucesso!']
        ]));
    }

    public function destroy(int $id)
    {
        try {
            $this->gamesService->destroy($id);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route("leaguefy.admin.games.index")->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Game excluído com sucesso!']
        ]));
    }

}
