<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Leaguefy\LeaguefyManager\Requests\StoreGameRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateGameRequest;
use Leaguefy\LeaguefyManager\Services\GamesService;

class GamesController extends Controller
{
    public function __construct(
        private GamesService $gamesService,
    ) {}

    public function index()
    {
        $data = $this->gamesService->list();

        return view('leaguefy-admin::games.index', [
            'columns' => [
                [
                    'column' => 'name',
                    'avatar' => 'logo',
                    'subtitle' => 'slug',
                ],
                'slug'
            ],
            'data' => $data,
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

    public function store(StoreGameRequest $request)
    {
        $this->gamesService->store($request);

        return redirect()->back()
            ->with('toastr', collect([
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

    public function update(int $id, UpdateGameRequest $request)
    {
        $this->gamesService->update($id, $request);

        return redirect()->back()
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Game atualizado com sucesso!']
            ]));
    }

    public function destroy(int $id)
    {
        $this->gamesService->destroy($id);

        return redirect()->back()
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Game excluído com sucesso!']
            ]));
    }

}
