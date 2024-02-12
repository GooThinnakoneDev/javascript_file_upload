<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 9 JavaScript File Upload with Progress Bar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5" style="max-width: 900px">
        <div class="alert alert-primary mb-4 text-center">
            <h2 class="display-6">Laravel 9 JavaScript File Upload with Progress Bar</h2>
        </div>
        @csrf
        <div class="card">
            <div class="card-header">Select File</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td width="50%" align="right"><b>Select File</b></td>
                        <td width="50%">
                            <input type="file" id="select_file" multiple />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="progress_bar" style="display: none;">
            <div id="progress_bar_process"></div>
        </div>
        <div id="uploaded_image"></div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // var file_element = document.getElementById('select_file');
    // var progress_bar = document.getElementById('progress_bar');
    // var progress_bar_process = document.getElementById('progress_bar_process');
    // var uploaded_image = document.getElementById('uploaded_image');

    // file_element.onchange = function() {
    //     var form_data = new FormData();
    //     form_data.append('sample_image', file_element.files[0]);
    //     form_data.append('_token', document.getElementsByName('_token')[0].value);
    //     progress_bar.style.display = 'block';
    //     axios.post("{{ route('upload_file.upload') }}", form_data, {
    //             onUploadProgress: function(progressEvent) {
    //                 var percentCompleted = Math.round((progressEvent.loaded / progressEvent.total) * 100);

    //                 progress_bar_process.style.width = percentCompleted + '%';
    //                 progress_bar_process.innerHTML = percentCompleted + '% completed';
    //             }
    //         })
    //         .then(function(response) {
    //             var file_data = response.data;
    //             uploaded_image.innerHTML =
    //                 '<div class="alert alert-success">Files Uploaded Successfully</div><video controls width="640" height="360"><source src="' +
    //                 file_data.image_path + '"/></video>';

    //             file_element.value = '';
    //         })
    //         .catch(function(error) {
    //             console.error('Error uploading file:', error);
    //         });
    // };
    var file_element = document.getElementById('select_file');
    var progress_bar = document.getElementById('progress_bar');
    var progress_bar_process = document.getElementById('progress_bar_process');
    var uploaded_image = document.getElementById('uploaded_image');

    file_element.onchange = function() {
        var files = file_element.files;
        var totalFiles = files.length;
        var currentIndex = 0;

        function uploadNextFile() {
            if (currentIndex < totalFiles) {
                var file = files[currentIndex];
                var form_data = new FormData();
                form_data.append('sample_image', file);
                form_data.append('_token', document.getElementsByName('_token')[0].value);
                progress_bar.style.display = 'block';

                axios.post("{{ route('upload_file.upload') }}", form_data, {
                        onUploadProgress: function(progressEvent) {
                            var percentCompleted = Math.round((progressEvent.loaded / progressEvent.total) *
                                100);

                            progress_bar_process.style.width = percentCompleted + '%';
                            progress_bar_process.innerHTML = percentCompleted + '% completed';
                        }
                    })
                    .then(function(response) {
                        var file_data = response.data;
                        var videoElement = document.createElement('video');
                        videoElement.controls = true;
                        videoElement.width = 640;
                        videoElement.height = 360;
                        var sourceElement = document.createElement('source');
                        sourceElement.src = file_data.image_path;
                        videoElement.appendChild(sourceElement);
                        uploaded_image.appendChild(videoElement);

                        currentIndex++;
                        uploadNextFile();
                    })
                    .catch(function(error) {
                        console.error('Error uploading file:', error);
                    });
            }
        }

        uploadNextFile();
    };
</script>
