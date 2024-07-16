@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Create
        </div>
        <div class="card-body">
            <form method="POST" action={{ route('admin.canteen.store') }} enctype="multipart/form-data" class="dropzone"
                id="dropzone">
                @csrf
                <div class="form-group">
                    <label class="required" for="event_date">Date </label>
                    <input id="menu_date" name="menu_date" type="text" class="form-control datetimepicker"
                        value={{ date('Y-m-d') }}>
                    <input type="hidden" name="save_send" value="send">
                    <label class="required pt-5" for="event_date">Photo </label>
                </div>


            </form>
            <button class="btn btn-success mt-3  pl-4 pr-4" type="submit" id="uploadfiles">
                {{ trans('global.save') }}
            </button>
            {{-- <button class="btn btn-success mt-3  pl-4 pr-4 btn_send" type="submit">
                {{ trans('global.save') }} & Send Notification
            </button> --}}
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            headers: {
                'X-CSRFToken': $('meta[name="token"]').attr('content')
            },
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100, // Number of files process at a time (default 2)
            maxFilesize: 4096, // maximum file size 2MB
            maxFiles: 100,
            timeout: 180000,
            resizeQuality: 0.5,
            addRemoveLinks: "true",
            acceptedFiles: ".jpeg,.jpg,.png,.pdf",
            dictDefaultMessage: '<dev class="btn btn-info mt-4 " >  Browse File  </dev>',
            dictResponseError: 'Error uploading file!',
            createImageThumbnails: true,
            dictRemoveFile: "Remove",
        });
        Dropzone.autoDiscover = false;
        myDropzone.on("success", function(file, response) {
            window.location.href = "{{ URL::to('admin/canteen') }}"
        });
        myDropzone.on('error', function(file, response) {
            // console.log(response.errors.file); // Log validation errors

        });
        $('#uploadfiles').click(function() {
            $('input[name="save_send"]').val("");
            if (myDropzone.files.length > 0) {
                myDropzone.processQueue();
            } else {
                $('#dropzone').submit();
            }
        });
        $(".btn_send").click(function() {
            $('input[name="save_send"]').val("send");
            if (myDropzone.files.length > 0) {
                myDropzone.processQueue();
            } else {
                $('#dropzone').submit();
            }
        });
        $(function() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY/MM/DD'
            });;
        });
    </script>
@endsection
