@php
    $currentPrefix = config('leaguefy-admin.route.prefix', null);
@endphp

<form method="post" action="{{ route('leaguefy.admin.settings.route-prefix.change') }}">
    @csrf
    <div class="form-group">
        <label for="routePrefix">Prefixo de Rotas</label>
        <input type="text"
            class="form-control"
            id="routePrefix"
            name="prefix"
            aria-describedby="routePrefixHelp"
            value="{{$currentPrefix}}"
            placeholder="Prefixo de Rotas">
        <small id="routePrefixHelp" class="form-text text-muted ">
            Rota base para todas as rotas da plataforma Leaguefy.
        </small>
    </div>

    @if(!is_null($currentPrefix) && $currentPrefix !== '')
    <button type="submit" class="btn btn-primary btn-sm mb-1 w-100">
        <i class="fas fa-fw fa-sm fa-save"></i>
        <span>Salvar alteração</span>
    </button>
    @endif

    @if(is_null($currentPrefix) || $currentPrefix === '')
    <button type="submit" class="btn btn-success btn-sm w-100">
        <i class="fas fa-fw fa-sm fa-plus"></i>
        <span>Adicionar prefixo</span>
    </button>
    @endif
</form>

@if(!is_null($currentPrefix) && $currentPrefix !== '')
<form method="post" action="{{ route('leaguefy.admin.settings.route-prefix.remove') }}">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm w-100">
        <i class="fas fa-fw fa-sm fa-times"></i>
        <span>Não quero prefixo</span>
    </button>
</form>
@endif
