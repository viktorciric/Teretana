
    Dropzone.options.dropzoneUpload = {
        url: 'Upload_photo.php',
        paramName: "photo",
        maxFilesize: 20, // MB
        acceptedFiles: "image/*",
        init: function() {
            this.on("success", function (file, response) {
                const jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    document.getElementById('photopathinput').value = jsonResponse.photo_path;
                } else {
                    console.log(jsonResponse.error);
                }
            });
        }
    };
