<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Leaguefy\LeaguefyManager\Requests\ConnectStageRequest;
use Leaguefy\LeaguefyManager\Requests\StoreStageRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateStageRequest;
use Leaguefy\LeaguefyManager\Services\StagesService;
use Leaguefy\LeaguefyManager\Services\TournamentsService;

class StagesController extends Controller
{
    public function __construct(
        private StagesService $stagesService,
        private TournamentsService $tournamentsService,
    ) {}

    public function index(int $id)
    {
        $data = $this->tournamentsService->find($id);

        return view('leaguefy-admin::tournaments.stages', [
            'tournament' => $data,
        ]);
    }

    public function store(int $tournament, StoreStageRequest $request)
    {
        $tournament = $this->tournamentsService->find($tournament);
        $request->merge(['tournament' => $tournament->slug]);

        $this->stagesService->store($request);

        return redirect()->back()
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Nova etapa adicionada!']
            ]));
    }

    public function update(int $tournament, int $stage, UpdateStageRequest $request)
    {
        $tournament = $this->tournamentsService->find($tournament);
        $request->merge(['tournament' => $tournament->slug]);

        $this->stagesService->update($stage, $request);

        return redirect()->back()
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Etapa atualizada com sucesso!']
            ]));
    }

    public function connect(int $tournament, ConnectStageRequest $request)
    {
        $tournament = $this->tournamentsService->find($tournament);
        $request->merge(['tournament' => $tournament->slug]);

        $connect = $this->stagesService->connect($request);

        return redirect()->back()
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => [
                    $connect === 'connected' ? 'Etapas conectadas!' : 'Etapas desconectadas!'
                ]
            ]));
    }

    public function destroy(int $tournament, int $stage)
    {
        $tournament = $this->tournamentsService->find($tournament);

        $this->stagesService->destroy($tournament->stages->find($stage)->id);

        return redirect()->back()
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Etapa removida com sucesso!']
            ]));
    }

}
