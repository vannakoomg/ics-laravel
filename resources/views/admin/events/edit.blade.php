@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.events.update', $event->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="required" for="from_date"> Start Date </label>
                            <input id="startdate" name="startdate" type="text"
                                class="form-control datetimepicker {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                value="{{ $event->start }}" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="required" for="to_date">End Date </label>
                            <input id="id" name="end_date" type="text"
                                class="form-control datetimepicker {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                value="{{ $endddd }}" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="" for="template_id">Evnet Type</label>
                            <select name='event_type_id' class="custom-select select2">
                                @foreach ($eventsType as $key => $Type)
                                    <option value="{{ $key }}"
                                        {{ $key + 1 == $event->event_type_id ? 'selected' : '' }}>
                                        {{ $Type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="required" for="From Date">Title</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ $event->title }}" required>
                </div>
                <div class="form-group">
                    <label for="time">Description</label>
                    <input class="form-control" type="text" name="time" id="name" value="{{ $event->time }}">
                </div>
                <div class="form-group pt-5">
                    <button class="btn btn-success mr-1" type="submit">
                        {{ trans('global.update') }}
                    </button>
                    <a class="btn btn-danger" href="{{ route('admin.events.destroy', $event->id) }}">
                        Delete
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY/MM/DD',
icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                }
            });;
        });
    </script>
@endsection
