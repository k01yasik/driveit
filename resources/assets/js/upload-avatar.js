$('.upload-button').click(function () {
   $('#change-avatar-input').click();
});

$('#change-avatar-input').change(function () {
    let selectedFile = $('#change-avatar-input')[0].files[0];

    if (selectedFile) {

        let formData = new FormData();
        formData.append('avatar_upload', selectedFile);
        formData.append('username', $( this ).data('username'));

        let img1 = new Image();
        img1.src = URL.createObjectURL(selectedFile);

        let heightImage, widthImage;

        img1.onload = function () {
            heightImage = img1.height;
            widthImage = img1.width;

            console.log(widthImage);
            console.log(heightImage);

            URL.revokeObjectURL(img1.src);

            let img = new Image(widthImage, heightImage);
            img.src = URL.createObjectURL(selectedFile);

            console.log(img.width);
            console.log(img.height);
            smartcrop.crop(img, { width: 200, height: 200}).then(function (result) {
                formData.append('x', result.topCrop.x);
                formData.append('y', result.topCrop.y);
                formData.append('height', result.topCrop.height);
                formData.append('width', result.topCrop.width);
                URL.revokeObjectURL(img.src);

                $.ajax({
                    method: "POST",
                    url: "/user/avatar/upload",
                    contentType: false,
                    processData: false,
                    dataType: 'text',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function (result) {

                    $('.avatar-inner img').attr('src', result);
                });
            });
        };
    }
});