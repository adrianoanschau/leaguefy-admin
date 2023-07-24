@extends('leaguefy-admin::page')

@section('content_header')
  <h1>Tournament Stages</h1>
@stop

@php
    $lanes = $tournament->stages->sortBy('position')->sortBy('lane')->groupBy('lane');
    $types = [
        'SINGLE' => 'Grupo Único',
        'MULTIPLE' => 'Múltiplos Grupos',
        'ELIMINATION' => 'Eliminatória',
        'FINAL' => 'Final',
    ];

    function getStagesConnections($stage)
    {
        return $stage->parents->map(fn ($v) => '"'.$v['lane'].':'.$v['position'].'"')->join(',');
    }
@endphp

@section('content')
    <form
        action="{{ route('leaguefy.admin.stages.store', [
            'tournament' => $tournament->id,
        ]) }}"
        method="post"
        class="d-flex flex-column align-items-center position-relative"
        data-leaguefy-stages="container" style="gap: 20px;">

        <div class="d-flex justify-content-center align-items-center" style="opacity: 0.25">
            <button type="button" class="btn px-1 py-2"
                data-leaguefy-stages="new-stage" data-lane-insert="start">
                <i class="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
            </button>
        </div>

        @php $stageCount = 1; @endphp
        @foreach($lanes as $stages)
        <div id="lane-{{$loop->index}}" class="d-flex justify-content-center align-items-center border rounded p-3 w-100">
            <div class="d-flex justify-content-center align-items-center" style="gap: 10px">
                <div class="d-flex justify-content-center align-items-center p-2" style="opacity: 0.25">
                    <button type="button" class="btn"
                        data-leaguefy-stages="new-stage" data-lane="{{$loop->index}}" data-position-insert="start">
                        <i class="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
                    </button>
                </div>
                <div class="card-deck" style="gap: 5px">
                @foreach($stages as $stage)
                    <div class="stage-card card card-outline card-secondary"
                        id="stage-{{$stage->lane}}:{{$stage->position}}"
                        {{ is_null($stage->parents->first()) ?:
                            "data-connect-to=[".getStagesConnections($stage)."]"
                        }}
                        style="min-width: 180px;">
                        <div class="card-header py-2 pl-2 pr-0">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title stage-name">
                                    <div data-bs-toggle="tooltip" title="{{ $stage['name'] ?? "Etapa ". $stageCount }}"
                                        style="max-width: 180px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                        <span>{{ $stage['name'] ?? "Etapa ". $stageCount }}</span>
                                    </div>
                                    <input type="text"
                                        class="form-control border-top-0 border-left-0 border-right-0 rounded-0 d-none p-0"
                                        title="Enter to confirm; Esc to cancel"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        value="{{ $stage['name'] ?? "Etapa ". $stageCount }}"
                                        data-leaguefy-stages="update"
                                        data-leaguefy-field="name"
                                        data-url="{{ route('leaguefy.admin.stages.update', [
                                            'tournament' => $tournament->id,
                                            'stage' => $stage->id,
                                        ]) }}"
                                        style="max-width: 180px">
                                </h5>
                                <div class="card-tools">
                                    <div class="dropdown" data-toggle="dropdown" aria-expanded="false">
                                        <button type="button"
                                            class="btn btn-tool pr-1 dropdown-toggle">
                                        </button>
                                        <div class="dropdown-menu">
                                            <button type="button"
                                                class="btn btn-default dropdown-item"
                                                data-leaguefy-stages="form-modal"
                                                data-stage="{{$stage->id}}"
                                                data-title="{{ $stage['name'] ?? "Etapa ". $stageCount }}"
                                                data-fields='["competitors:{{$stage->competitors}}","classify:{{$stage->classify}}"]'>
                                                <i class="fas fa-fw fa-pen"></i>
                                                <span>Edit</span>
                                            </button>
                                            <button type="button" class="btn btn-default dropdown-item"
                                                data-leaguefy-stages="remove" data-card-widget="remove"
                                                data-url="{{ route('leaguefy.admin.stages.destroy', [
                                                    'tournament' => $tournament->id,
                                                    'stage' => $stage->id,
                                                ]) }}">
                                                <i class="fas fa-fw fa-times"></i>
                                                <span>Remove</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush border-bottom-0">
                            <li class="list-group-item list-group-item-action p-0">
                                <div class="btn-group p-0 w-100 rounded-0 stage-type-change">
                                    <button type="button"
                                        @class([
                                            "btn btn-sm rounded-0 p-1",
                                            "btn-default" => $stage['type'] !== Leaguefy\LeaguefyManager\Enums\StageTypes::SINGLE(),
                                            "btn-primary" => $stage['type'] === Leaguefy\LeaguefyManager\Enums\StageTypes::SINGLE(),
                                        ])
                                        title="type: {{Leaguefy\LeaguefyManager\Enums\StageTypes::SINGLE()}}"
                                        data-bs-toggle="tooltip"
                                        data-placement="bottom"
                                        data-leaguefy-stages="update"
                                        data-leaguefy-field="type"
                                        data-leaguefy-value="{{Leaguefy\LeaguefyManager\Enums\StageTypes::SINGLE()}}"
                                        data-url="{{ route('leaguefy.admin.stages.update', [
                                            'tournament' => $tournament->id,
                                            'stage' => $stage->id,
                                        ]) }}">
                                        <i class="fas fa-fw fa-square"></i>
                                    </button>
                                    <button type="button"
                                        @class([
                                            "btn btn-sm rounded-0 p-1",
                                            "btn-default" => $stage['type'] !== Leaguefy\LeaguefyManager\Enums\StageTypes::MULTIPLE(),
                                            "btn-primary" => $stage['type'] === Leaguefy\LeaguefyManager\Enums\StageTypes::MULTIPLE(),
                                        ])
                                        title="type: {{Leaguefy\LeaguefyManager\Enums\StageTypes::MULTIPLE()}}"
                                        data-bs-toggle="tooltip"
                                        data-placement="bottom"
                                        data-leaguefy-stages="update"
                                        data-leaguefy-field="type"
                                        data-leaguefy-value="{{Leaguefy\LeaguefyManager\Enums\StageTypes::MULTIPLE()}}"
                                        data-url="{{ route('leaguefy.admin.stages.update', [
                                            'tournament' => $tournament->id,
                                            'stage' => $stage->id,
                                        ]) }}">
                                        <i class="fas fa-fw fa-th-large"></i>
                                    </button>
                                    <button type="button"
                                        @class([
                                            "btn btn-sm rounded-0 p-1",
                                            "btn-default" => $stage['type'] !== Leaguefy\LeaguefyManager\Enums\StageTypes::ELIMINATION(),
                                            "btn-primary" => $stage['type'] === Leaguefy\LeaguefyManager\Enums\StageTypes::ELIMINATION(),
                                        ])
                                        title="type: {{Leaguefy\LeaguefyManager\Enums\StageTypes::ELIMINATION()}}"
                                        data-bs-toggle="tooltip"
                                        data-placement="bottom"
                                        data-leaguefy-stages="update"
                                        data-leaguefy-field="type"
                                        data-leaguefy-value="{{Leaguefy\LeaguefyManager\Enums\StageTypes::ELIMINATION()}}"
                                        data-url="{{ route('leaguefy.admin.stages.update', [
                                            'tournament' => $tournament->id,
                                            'stage' => $stage->id,
                                        ]) }}">
                                        <i class="fas fa-fw fa-sitemap"></i>
                                    </button>
                                    <button type="button"
                                        @class([
                                            "btn btn-sm rounded-0 p-1",
                                            "btn-default" => $stage['type'] !== Leaguefy\LeaguefyManager\Enums\StageTypes::FINAL(),
                                            "btn-primary" => $stage['type'] === Leaguefy\LeaguefyManager\Enums\StageTypes::FINAL(),
                                        ])
                                        title="type: {{Leaguefy\LeaguefyManager\Enums\StageTypes::FINAL()}}"
                                        data-bs-toggle="tooltip"
                                        data-placement="bottom"
                                        data-leaguefy-stages="update"
                                        data-leaguefy-field="type"
                                        data-leaguefy-value="{{Leaguefy\LeaguefyManager\Enums\StageTypes::FINAL()}}"
                                        data-url="{{ route('leaguefy.admin.stages.update', [
                                            'tournament' => $tournament->id,
                                            'stage' => $stage->id,
                                        ]) }}">
                                        <i class="fas fa-fw fa-grip-lines"></i>
                                    </button>
                                </div>
                            </li>
                            @if(count($stage['groups']) > 1) <li class="list-group-item">{{count($stage['groups'])}} grupos</li> @endif
                        </ul>
                        <div class="overlay d-none"></div>
                        @if (!$loop->parent->first)
                        <div class="stage-link position-absolute rounded-circle bg-white text-center btn btn-light p-0 d-none"
                            style="width: 24px; height: 24px; left: calc(50% - 12px); top: -12px; z-index: 1">
                            <i class="fas fa-fw fa-times fa-sm text-danger d-none" style="padding: 4px 6px"></i>
                            <i class="fas fa-fw fa-link fa-sm text-muted"></i>
                        </div>
                        @endif
                        @if (!$loop->parent->last)
                        <div class="position-absolute rounded-circle bg-white text-center parent-link"
                            style="width: 24px; height: 24px; left: calc(50% - 12px); bottom: -12px; z-index: 1">
                            <i class="fas fa-fw fa-unlink fa-sm text-muted"></i>
                        </div>
                        <div class="position-absolute rounded-circle bg-white text-center connect-link btn btn-light p-0 d-none"
                            style="width: 24px; height: 24px; left: calc(50% - 12px); bottom: -12px; z-index: 1">
                            <i class="fas fa-fw fa-link fa-sm text-success"></i>
                            <i class="fas fa-fw fa-times fa-sm text-danger d-none" style="padding: 4px 6px"></i>
                        </div>
                        @endif
                    </div>
                    @php $stageCount += 1; @endphp
                @endforeach
                </div>
                <div class="d-flex justify-content-center align-items-center p-2" style="opacity: 0.25">
                    <button type="button" class="btn"
                        data-leaguefy-stages="new-stage" data-lane="{{$loop->index}}" data-position-insert="end">
                        <i class="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-center align-items-center" style="opacity: 0.25">
            <button type="button" class="btn px-1 py-2"
                data-leaguefy-stages="new-stage" data-lane-insert="end">
                <i class="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
            </button>
        </div>
    </form>

    <div class="modal fade" id="editStage" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('leaguefy.admin.stages.update', [
                            'tournament' => $tournament->id,
                            'stage' => '#editStage'
                        ]) }}" method="post" pjax-container>
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="competitors" class="col-form-label">Participam:</label>
                          <input type="number" class="form-control" id="competitors" name="competitors" min="2" />
                        </div>
                        <div class="form-group">
                          <label for="classify" class="col-form-label">Classificam:</label>
                          <input type="number" class="form-control" id="classify" name="classify" min="1" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form action="{{ route('leaguefy.admin.stages.connect', [
        'tournament' => $tournament->id,
    ]) }}"
    method="post" data-leaguefy-stages="connection">
    </form>
@endsection

@push('css')
<style>
    .stage-card {
        border-width: 1px;
    }
    #app:not(.stage-link-in-connection) .stage-card:hover .stage-link,
    .stage-card.stage-link-disconnect .stage-link {
        display: block!important;
    }

    .stage-link-in-connection .stage-card .overlay {
        display: block!important;
    }

    .stage-link-connect .stage-card .overlay,
    .stage-link-disconnect.stage-card .overlay {
        display: none!important;
    }

    .stage-link-connect .stage-card .card-header {
        cursor: pointer;
    }
    .stage-link-connect .stage-card {
        border-color: lightgreen;
    }
    .stage-link-connect .stage-card .connect-link {
        display: block!important;
    }
    .stage-link-disconnect.stage-card,
    .stage-link-connect .stage-card:hover {
        border-color: green;
    }
    .stage-card.stage-link-disconnect:hover {
        border-color: red;
    }
    .stage-card.stage-link-disconnect:hover .fa-link {
        display: none!important;
    }
    .stage-card.stage-link-disconnect:hover .fa-times {
        display: block!important;
    }
    .stage-link-connect .stage-connected .connect-link .text-success {
        display: none!important;
    }
    .stage-link-connect .stage-connected .connect-link .text-danger {
        display: block!important;
    }
    .stage-card .stage-name.edit-name > div {
        display: none;
    }
    .stage-card .stage-name.edit-name > input {
        display: block!important;
    }
</style>
@endpush
