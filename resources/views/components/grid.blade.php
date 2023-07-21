<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">Games</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <x-adminlte-datatable id="table1" :heads="$columns" hoverable >
            @foreach($data as $row)
                <tr>
                    @foreach($columns as $column)
                        <td>{!! $row[$column] !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</div>
