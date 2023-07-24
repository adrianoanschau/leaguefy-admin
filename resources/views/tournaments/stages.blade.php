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

        @foreach($lanes as $stages)
        <div id="lane-{{$loop->index}}" class="d-flex justify-content-center align-items-center border rounded p-3 w-100">
            <div class="d-flex justify-content-center align-items-center" style="gap: 5px">
                    @foreach($stages as $stage)
                        @if($loop->index === 0)
                        <div class="d-flex justify-content-center align-items-center p-2" style="opacity: 0.25">
                            <button type="button" class="btn"
                                data-leaguefy-stages="new-stage" data-lane="{{$loop->parent->index}}" data-position-insert="start">
                                <i class="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
                            </button>
                        </div>
                        @endif
                        <div class="stage-card card m-0 w-100"
                            id="stage-{{$stage->lane}}:{{$stage->position}}"
                            {{ is_null($stage->parents->first()) ?:
                                "data-connect-to=[".getStagesConnections($stage)."]"
                            }}>
                            <div class="card-header">
                                <h5 class="card-title">
                                    {{ $stage['name'] ?? "Etapa ". $loop->index + 1 }}
                                </h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">{{$types[$stage['type']]}}</li>
                                @if(count($stage['groups']) > 1) <li class="list-group-item">{{count($stage['groups'])}} grupos</li> @endif
                            </ul>
                            <div class="card-footer p-0 btn-group">
                                <button type="button" class="remove-stage btn btn-sm btn-outline-danger"
                                    data-url="{{ route('leaguefy.admin.stages.destroy', [
                                        'tournament' => $tournament->id,
                                        'stage' => $stage->id,
                                    ]) }}">
                                    Remover
                                </button>
                            </div>
                            @if (!$loop->parent->first)
                            <div class="stage-link position-absolute rounded-circle bg-white text-center btn btn-light p-0 d-none"
                                style="width: 24px; height: 24px; left: calc(50% - 12px); top: -12px; z-index: 1">
                                <i class="fas fa-fw fa-times fa-sm text-danger " style="display: none; padding: 4px 6px"></i>
                                <i class="fas fa-fw fa-link fa-sm text-muted"></i>
                            </div>
                            @endif
                            @if (!$loop->parent->last)
                            <div class="position-absolute rounded-circle bg-white text-center parent-link"
                                style="width: 24px; height: 24px; left: calc(50% - 12px); bottom: -12px; z-index: 1">
                                <i class="fas fa-fw fa-unlink fa-sm text-muted "></i>
                            </div>
                            @endif
                        </div>
                        @if($loop->index === count($stages) - 1)
                        <div class="d-flex justify-content-center align-items-center p-2" style="opacity: 0.25">
                            <button type="button" class="btn"
                                data-leaguefy-stages="new-stage" data-lane="{{$loop->parent->index}}" data-position-insert="end">
                                <i class="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
                            </button>
                        </div>
                        @endif
                    @endforeach
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

    <form action="{{ route('leaguefy.admin.stages.connect', [
        'tournament' => $tournament->id,
    ]) }}"
    method="post" data-leaguefy-stages="connection"></form>
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

    .stage-link-connect .stage-card {
        cursor: pointer;
    }
    .stage-link-connect .stage-card {
        border-color: lightgreen;
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
</style>
@endpush
