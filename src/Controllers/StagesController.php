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
        $tournament = $this->tournamentsService->find($id);

        return view('leaguefy-admin::tournaments.stages', [
            'tournament' => $tournament,
        ]);
    }

    public function store(int $tournament, StoreStageRequest $request)
    {
        try {
            $tournament = $this->tournamentsService->find($tournament);
            $request->merge(['tournament' => $tournament->slug]);

            $this->stagesService->store($request);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->back()->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Nova etapa adicionada!']
        ]));
    }

    public function update(int $tournament, int $stage, UpdateStageRequest $request)
    {
        try {
            $tournament = $this->tournamentsService->find($tournament);
            $request->merge(['tournament' => $tournament->slug]);

            $this->stagesService->update($stage, $request);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->back()->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Etapa atualizada com sucesso!']
        ]));
    }

    public function connect(int $tournament, ConnectStageRequest $request)
    {
        try {
            $tournament = $this->tournamentsService->find($tournament);
            $request->merge(['tournament' => $tournament->slug]);

            $connect = $this->stagesService->connect($request);
        } catch (\Throwable $th) {
            dd($th);
        }

        $message = $connect === 'connected' ? 'Etapas conectadas!' : 'Etapas desconectadas!';

        return redirect()->back()->with('toastr', collect([
            'type' => ['success'],
            'message' => [$message]
        ]));
    }

    public function destroy(int $tournament, int $stage)
    {
        try {
            $tournament = $this->tournamentsService->find($tournament);

            $this->stagesService->destroy($tournament->stages->find($stage)->id);
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->back()->with('toastr', collect([
            'type' => ['success'],
            'message' => ['Etapa removida com sucesso!']
        ]));
    }

}
