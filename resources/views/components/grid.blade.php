<div class="card ">
    <div class="card-body p-3">
        <div class="table-responsive w-100">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead>
                    <tr>
                        @foreach($columns as $column)
                            <th @class([
                                "py-3 border-bottom-0 border-top-0 w-full", $column['classes']
                            ])>
                                {!! $column['label'] !!}
                            </th>
                        @endforeach
                        <th class="py-3 border-bottom-0 border-top-0" style="width: 220px">
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-sm btn-success border-0" href="{{ route("leaguefy.admin.{$name}s.create") }}">
                                    <i class="fas fa-fw fa-plus"></i>
                                    <span class="d-none d-sm-inline">Criar</span>
                                </a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($data->isEmpty())
                        <tr>
                            <td class="bg-light p-5" colspan="{{ count($columns) + 1 }}">
                                <div class="d-flex flex-column align-items-center text-black-50">
                                    <i class="fas fa-fw fa-inbox fa-2xl" style="font-size: 5rem"></i>
                                    <span>Empty</span>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @foreach($data as $row)
                        <tr>
                            @foreach($columns as $column)
                                <td @class(["align-middle", $column['classes']])>
                                    @if(!is_null($column['link_route']))
                                        <div class="">
                                            <a href="{{ route("leaguefy.admin.{$column['link_route']}.index", [
                                                $name => $row['id'],
                                            ]) }}" class="btn btn-sm btn-link">
                                                <i class="fas {{$column['link_icon']}}"></i>
                                            </a>
                                        </div>
                                    @elseif(!is_null($column['avatar']) || !is_null($column['subtitle']))
                                        <div class="d-flex align-items-center">
                                            @if(!is_null($column['avatar']))
                                                <div class="bg-light rounded-full" style="width: 45px; height: 45px;"></div>
                                            @endif
                                            @if(!is_null($column['subtitle']))
                                                <div @class([ 'ml-3' => !is_null($column['avatar'])])>
                                                    <p class="fw-normal mb-1">{!! $row[$column['column']] !!}</p>
                                                    <p class="text-muted mb-0">{!! $row[$column['subtitle']] !!}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        {!! $row[$column['column']] !!}
                                    @endif
                                </td>
                            @endforeach
                            <td class="align-middle" style="width: 220px">
                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-outline-primary btn-sm border-0" href="{{ route("leaguefy.admin.{$name}s.edit", [$name => $row['id']]) }}">
                                        <i class="fas fa-fw fa-pen"></i>
                                        <span class="d-none d-sm-inline">Editar</span>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0"
                                        data-swal-confirm="submit" data-swal-target="#delete-form-{{$name.$row['id']}}">
                                        <i class="fas fa-fw fa-trash"></i>
                                        <span class="d-none d-sm-inline">Excluir</span>
                                    </button>
                                    <form id="delete-form-{{$name.$row['id']}}" method="POST" action="{{ route("leaguefy.admin.{$name}s.destroy", [
                                        $name => $row['id']
                                    ]) }}" pjax-container>
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
