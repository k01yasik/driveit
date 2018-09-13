$().ready(function () {

    let storage = localStorage.getItem('title-post-image-url');

    if (storage) {
        let image_element = "<img src=" + storage + " class='uploaded-image' />";

        $('.block-wrapper').after(image_element);

        $('#image').val(storage);
    }

    $('.post_upload_image_button').click(function () {
        $('#post_upload_image_input').click();
    });

    $('#post_upload_image_input').change(function () {

        let url = $('#image').val();

        if (url !== '') {

            $.ajax({
                method: "DELETE",
                url: "/admin/posts/image-destroy" + '?' + $.param({url: url}),
                contentType: false,
                processData: false,
                dataType: 'text',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done( function () {

                let selectedFile = $('#post_upload_image_input')[0].files[0];

                let formData = new FormData();
                formData.append('post_upload', selectedFile);

                if (selectedFile) {

                    $.ajax({
                        method: "POST",
                        url: "/admin/posts/image-upload",
                        contentType: false,
                        processData: false,
                        dataType: 'text',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }).done(function (result) {

                        $('.uploaded-image').remove();

                        let image_element = "<img src=" + result + " class='uploaded-image' />";

                        $('.block-wrapper').after(image_element);

                        $('#image').val(result);

                        localStorage.setItem('title-post-image-url', result);

                    });

                }
            });

        } else {
            let selectedFile = $('#post_upload_image_input')[0].files[0];

            let formData = new FormData();
            formData.append('post_upload', selectedFile);

            if (selectedFile) {

                $.ajax({
                    method: "POST",
                    url: "/admin/posts/image-upload",
                    contentType: false,
                    processData: false,
                    dataType: 'text',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function (result) {

                    let image_element = "<img src="+ result + " class='uploaded-image' />";

                    $('.block-wrapper').after(image_element);

                    $('#image').val(result);

                    localStorage.setItem('title-post-image-url', result);

                });

            }
        }
    });
});