@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit
        </div>
        <div class="card-body">
            <form method="POST" action={{ route('admin.gallary.update', $gallary->id) }} enctype="multipart/form-data"
                class="dropzone" id="dropzone">
                @csrf
                <div class="form-group mb-4">
                    <label class="required" for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ $gallary->name }}" />
                </div>
                <div class="form-group mb-4">
                    <label class="required" for="event_date">Event Date </label>
                    <input id="event_date" name="event_date" type="text" class="form-control datetimepicker"
                        value={{ $gallary->event_date }}>
                </div>
                <div id="loading" style="display: none; color: rgb(23, 188, 23); ">
                    <strong>Compressing image...</strong>
                    <div id="progressBarContainer"></div>
                </div>
                <div class="dz-message" data-dz-message>
                    <dev class="btn btn-info mt-4 "> Browse File </dev>
                </div>
            </form>
            <div class="form-group mb-4"><button class="btn btn-success mt-4" type="submit" id="update-btn">
                    {{ trans('global.save') }}
                </button></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: false,
            uploadMultiple: true,
            addRemoveLinks: true,
            parallelUploads: 100, // Number of files process at a time (default 2)
            maxFilesize: 100, //maximum file size 2MB
            maxFiles: 100,
            acceptedFiles: ".jpeg,.jpg,.png,.pdf",
            dictDefaultMessage: '',
            dictResponseError: 'Error uploading file!',
            parallelChunkUploads: true,
            createImageThumbnails: true,
            dictRemoveFile: "Remove",
            init: function() { // start of getting existing imahes
  document.querySelector('.dz-message').style.display = 'block';               
 myDropzone = this;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    url: '{{ route('admin.gallary.init') }}',
                    type: "GET",
                    data: {
                        id: {{ $gallary->id }},
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    dataType: "json",
                    success: function(response) { // get result
                        console.log(response);
                        $.each(response, function(key, value) {
                            var mockFile = {
                                name: "http://school.ics.edu.kh/storage/image/" +
                                    value.filename,
                                size: value.size,
                                id: value.id
                            };
                            myDropzone.options.addedfile.call(
                                myDropzone,
                                mockFile,
                                // name: $file,
                            );
                            myDropzone.options.thumbnail.call(
                                myDropzone,
                                mockFile,
                                "http://school.ics.edu.kh/storage/image/" +
                                value.filename,
                            );
                            $("[thumbnail]").css("height", "240");
                            $("[data-dz-thumbnail]").css("width", "240");
                            $("[data-dz-thumbnail]").css("object-fit", "cover");
                        });

                    }
                });

            },
            removedfile: function(file) {
                var name = file.filename;
                console.log(file.id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    url: '{{ route('admin.gallary.destroy') }}',
                    type: 'POST',
                    data: "id=" + file.id + '&_token=' + "{{ csrf_token() }}",
                    dataType: 'html',
                    success: function(data) {
                        console.log("successfully removed!!");
                    },

                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
        });
        myDropzone.on("addedfile", function(file) {
            if (file.type.match('image/jpeg') || file.type.match('image/png')) {
                if (file.size > 1024 * 824) { // Check if file size is greater than 1MB
                    console.log("image size", file.size);
                    $('#loading').show(); // Show loading element
                    compressImage(file, 5000);
                }
            }
            document.querySelector('.dz-message').style.display = 'block';

        });
        myDropzone.on("success", function(file, response) {
            window.location.href = "{{ URL::to('admin/gallary') }}"
        });
        myDropzone.on("error", function(file, errorMessage) {
            if (errorMessage == "You can't upload files of this type.") {
                alert("Allow only PNG and JPG");
                myDropzone.removeFile(file);
            }
        });
        $('#update-btn').click(function(e) {
            const title = document.getElementById('title').value;

            if (myDropzone.files.length > 0 && title != "") {
                myDropzone.processQueue();
            } else {
                $('#dropzone').submit();
            }
        });
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
