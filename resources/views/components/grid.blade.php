<div class="card">
    @if(isset($title))
    <div class="card-header border-0">
        <h3 class="card-title">{{$title}}</h3>
    </div>
    @endif
    <div class="card-body table-responsive p-0">
        <x-adminlte-datatable id="table1" :heads="$columns" hoverable >
            @foreach($data as $row)
                <tr>
                    @foreach($columns as $column)
                        @if(is_string($column))
                            <td>{!! $row[$column] !!}</td>
                        @else
                            <td>{!! $row[$column['column']] !!}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</div>
