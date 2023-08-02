<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Inertia\Inertia;
use Leaguefy\LeaguefyManager\Services\GamesService;
use Leaguefy\LeaguefyManager\Requests\StoreGameRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateGameRequest;

class GamesController extends Controller
{
    public function __construct(
        private GamesService $gamesService,
    ) {}

    public function index()
    {
        $data = $this->gamesService->list();

        return Inertia::render('Games/List', [
            'data' => $data,
        ]);
    }

    public function create()
    {
        return Inertia::render('Games/Form');
    }

    public function store(StoreGameRequest $request)
    {
        $this->gamesService->store($request);

        return to_route("leaguefy.admin.games.index")
            ->with('toastr', collect([
                'type' => 'success',
                'message' => 'Game criado com sucesso!',
            ]));
    }

    public function edit(string $id)
    {
        $data = $this->gamesService->find($id);

        return Inertia::render('Games/Form', [
            'id' => $id,
            'data' => $data,
        ]);
    }

    public function update(string $id, UpdateGameRequest $request)
    {
        $this->gamesService->update($id, $request);

        return to_route("leaguefy.admin.games.index")
            ->with('toastr', collect([
                'type' => 'success',
                'message' => 'Game atualizado com sucesso!',
            ]));
    }

    public function destroy(string $id)
    {
        $this->gamesService->destroy($id);

        return to_route("leaguefy.admin.games.index")
            ->with('toastr', collect([
                'type' => 'success',
                'message' => 'Game excluído com sucesso!',
            ]));
    }

}
