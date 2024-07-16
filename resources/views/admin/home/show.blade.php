@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Student No App In {{ $cam }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover datatable datatable-User">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>UserID</th>
                            <th>Name</th>
                            <th>NameKH</th>
                            <th>className</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $key => $value)
                            <div class="row">
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->namekh }}</td>
                                    <td>{{ $value->class_name }}</td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            $.extend(true, $.fn.dataTable.defaults, {
                pageLength: 30,
            });
            $('.datatable-User:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
