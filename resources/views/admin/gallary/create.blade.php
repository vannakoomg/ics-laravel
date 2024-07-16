@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Create
        </div>
        <div class="card-body">
            <form method="POST" action={{ route('admin.gallary.store') }} enctype="multipart/form-data" class="dropzone"
                id="dropzone" name="dropzone">
                @csrf
                <div class="form-group mb-4">
                    <label class="required" for="From Date">Title</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ old('name', '') }}" required>
                </div>
                <div class="form-group">
                    <label class="required" for="event_date">Event Date </label>
                    <input id="event_date" name="event_date" type="text" class="form-control datetimepicker"
                        value={{ date('Y-m-d') }}>
                </div>
                <div id="loading" style="display: none; color: rgb(15, 196, 15); ">
                    <strong>Compressing image...</strong>
                    <div id="progressBarContainer"></div>
                </div>
                <div class="dz-message" data-dz-message>
                    <dev class="btn btn-info mt-4 "> Browse File </dev>
                </div>
            </form>

            <button class="btn btn-success pl-4 pr-4 mt-3" type="submit" id="uploadfiles">
                {{ trans('global.save') }}
            </button>
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
            maxFilesize: 4096, //maximum file size 2MB
            maxFiles: 100,
            timeout: 180000,
            resizeQuality: 0.5,
            addRemoveLinks: "true",
            acceptedFiles: ".jpeg,.jpg,.png",
            dictDefaultMessage: '<dev class="btn btn-info mt-4 " >  Browse File  </dev>',
            dictResponseError: 'Error uploading file!',
            createImageThumbnails: true,
            dictRemoveFile: "Remove",
            init: function() {
                this.on("addedfile", function(file) {
                    if (file.type.match('image/jpeg') || file.type.match('image/png')) {
                        if (file.size > 1024 * 824) { // Check if file size is greater than 1MB
                            console.log("image size", file.size);
                            $('#loading').show(); // Show loading element
                            compressImage(file, 5000);
                        }
                    }
                    document.querySelector('.dz-message').style.display = 'block';

                });
            }
        });
        Dropzone.autoDiscover = false;
        myDropzone.on("success", function(file, response) {
            window.location.href = "{{ URL::to('admin/gallary') }}"
        });
        myDropzone.on("error", function(file, errorMessage) {
            if (errorMessage == "You can't upload files of this type.") {
                alert("Allow only PNG and JPG");
                myDropzone.removeFile(file);
            }
        });
        $('#uploadfiles').click(function() {
            const title = document.getElementById('title').value;
            console.log(title);
            if (myDropzone.files.length > 0 && title != "") {
                myDropzone.processQueue();
            } else {
                $('#dropzone').submit();
            }
        });
        $(function() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY/MM/DD',
                locale: 'en',
                sideBySide: true,
                icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                }
            });
        });

        function compressImage(file, maxSizeInKB) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var image = new Image();
                image.src = event.target.result;
                image.onload = function() {
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");
                    var width = image.width;
                    var height = image.height;
                    var maxSize = maxSizeInKB * 1024; // Convert KB to bytes
                    var ratio = 1;
                    if (width * height > maxSize) {
                        ratio = Math.sqrt(maxSize / (width * height));
                    }
                    canvas.width = width * ratio;
                    canvas.height = height * ratio;
                    ctx.drawImage(image, 0, 0, canvas.width, canvas.height);

                    canvas.toBlob(function(blob) {
                        var newFile = new File([blob], file.name, {
                            type: "image/jpeg",
                            lastModified: Date.now()
                        });
                        myDropzone.removeFile(file);
                        myDropzone.addFile(newFile);
                        // Replace the original file with the compressed file
                        $('#loading').hide();
                    }, "image/jpeg", 0.7); // 0.7 is the JPEG quality, adjust as needed
                };
            };
            reader.readAsDataURL(file);
            console.log(reader);
        }
    </script>
@endsection
