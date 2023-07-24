<div class="card p-3 ">
    <div class="card-header">
        <div class="card-tools">
            <div class="d-flex justify-content-end">
                <a class="btn btn-sm btn-light border-0" href="{{ route("leaguefy.admin.{$name}s.index") }}">
                    <i class="fas fa-fw fa-list"></i>
                    <span class="d-none d-sm-inline">Listar</span>
                </a>
            </div>
        </div>
    </div>
    <form action="{{ route("leaguefy.admin.{$name}s.".(isset($id)?'update':'store'), [$name => $id]) }}"
        method="post"
        class="form-horizontal"
        pjax-container>
        <div class="card-body px-0">
            @foreach($fields as $field)
                <div class="form-group row">
                    <label for="{{$field['column']}}" class="col-sm-2 col-form-label">
                        {{$field['label']}}
                    </label>
                    <div class="col-sm-10">
                        @if(!is_null($field['options']))
                            <select
                                id="{{$field['column']}}"
                                class="form-control"
                                name="{{$field['column']}}"
                                {{ !$field['disabled'] ?: 'disabled' }}>
                                <option value=""></option>
                                @foreach($field['options'] as $index => $option)
                                    <option value="{{ $index }}">{!! $option !!}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="{{$field['type']}}"
                                id="{{$field['column']}}"
                                name="{{$field['column']}}"
                                class="form-control"
                                placeholder="{{$field['label']}}"
                                value="{{data_get(@$data, $field['column'])}}"
                                {{ !$field['disabled'] ?: 'disabled' }}>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card-footer">
            <div class="float-right">
                <button type="button" class="btn btn-warning">
                    <i class="fas fa-fw fa-broom"></i>
                    Limpar
                </button>
                <button class="btn btn-primary">
                    <i class="fas fa-fw fa-save"></i>
                    @if(!isset($id))
                        Salvar
                    @else
                        Atualizar
                    @endif
                </button>
            </div>
        </div>
        @method(isset($id) ? 'PUT' : 'POST')
        @csrf
    </form>
</div>
