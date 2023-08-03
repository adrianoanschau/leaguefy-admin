<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Inertia\Inertia;
use Leaguefy\LeaguefyManager\Services\StagesService;
use Leaguefy\LeaguefyManager\Requests\StoreStageRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateStageRequest;
use Leaguefy\LeaguefyManager\Services\TournamentsService;
use Leaguefy\LeaguefyManager\Requests\ConnectStageRequest;

class StagesController extends Controller
{
    public function __construct(
        private StagesService $stagesService,
        private TournamentsService $tournamentsService,
    ) {}

    public function index(string $tournamentId)
    {
        $tournament = $this->tournamentsService->find($tournamentId);

        return Inertia::render('Tournaments/StagesFlow', [
            'tournament' => $tournament,
            'lanes' => $tournament->stages->load(['parents', 'children'])->sortBy('position')->sortBy('lane')->groupBy('lane'),
        ]);
    }

    public function store(string $tournamentId, StoreStageRequest $request)
    {
        $tournament = $this->tournamentsService->find($tournamentId);
        $request->merge(['tournament' => $tournament->slug]);

        $this->stagesService->store($request);

        return redirect()->action([self::class, 'index'], ['tournament' => $tournamentId])
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Nova etapa adicionada!']
            ]));
    }

    public function update(string $tournamentId, string $stage, UpdateStageRequest $request)
    {
        $tournament = $this->tournamentsService->find($tournamentId);
        $request->merge(['tournament' => $tournament->slug]);

        $this->stagesService->update($stage, $request);

        return redirect()->action([self::class, 'index'], ['tournament' => $tournamentId])
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Etapa atualizada com sucesso!']
            ]));
    }

    public function connect(string $tournamentId, ConnectStageRequest $request)
    {
        $tournament = $this->tournamentsService->find($tournamentId);
        $request->merge(['tournament' => $tournament->slug]);

        $connect = $this->stagesService->connect($request);

        return redirect()->action([self::class, 'index'], ['tournament' => $tournamentId])
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => [
                    $connect === 'connected' ? 'Etapas conectadas!' : 'Etapas desconectadas!'
                ]
            ]));
    }

    public function destroy(string $tournamentId, string $stage)
    {
        $tournament = $this->tournamentsService->find($tournamentId);

        $this->stagesService->destroy($tournament->stages->find($stage)->id);

        return redirect()->action([self::class, 'index'], ['tournament' => $tournamentId])
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Etapa removida com sucesso!']
            ]));
    }

}
