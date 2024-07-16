@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('css/xzoom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet" />
@endsection

@section('content')
       
    <div class="card">
        <div class="card-header">
		 <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.canteen.create') }}">
                    {{ trans('global.add') }}
                </a>
            </div>
        </div>
            <form method="get" action="{{ route('admin.canteen.index') }}" id="form1">
                <span>
                    {{ trans('global.list') }} of MEUNd
                </span>
                {{-- <span class="float-right form-check form-switch">
                    <input type="checkbox" name="chk_show" class="form-check-input"
                        {{ request()->chk_show == 'on' ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">
                        Show Sent
                    </label>
                </span> --}}
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-sm table-bordered table-striped table-hover datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>

                            <th>
                                Data
                            </th>
                            <th>
                                {{ trans('Posted by') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menu as $menu)
                            <tr>
                                <td> </td>
                                <td>{{ $menu->menu_date }}</td>
                                <td>
                                    {{ $menu->user_name }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.canteen.edit', $menu->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form action="{{ route('admin.canteen.destroyMenu', $menu->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                            value="{{ trans('global.delete') }}">
                                    </form>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="{{ asset('js/xzoom.min.js') }}"></script>
    <script src="{{ asset('js/magnific-popup.js') }}"></script>
    <script src="{{ asset('js/jquery.hammer.min.js') }}"></script>


    <script>
        $(function() {

            $('input[type="checkbox"]').on("change", function() {
                $('#form1').submit();
            });

            $('.xzoom-gallery').bind('click', function(event) {
                var div = $(this).parents('.xzoom-thumbs');

                images = new Array();

                var img_length = div.find('img').length;
                for (i = 0; i < img_length; i++)
                    images[i] = {
                        src: div.find('img').eq(i).attr("src")
                    };
                $.magnificPopup.open({
                    items: images,
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
                event.preventDefault();
            });

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


            $.extend(true, $.fn.dataTable.defaults, {
                // order: [[ 1, 'desc' ]],
                pageLength: 30,
            });
            $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
