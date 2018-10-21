$().ready(function () {
    $('.image-wrapper').on('click', '.image-block-footer-button', function () {
        let element = $( this );
        let id = element.data('id');
        let username = element.data('username');

        let formData = new FormData();
        formData.append('id', id);
        formData.append('username', username);

        $.ajax({
            method: "POST",
            url: "/user/favorite/add",
            contentType: false,
            processData: false,
            dataType: 'text',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (result) {
            element.parent().prev().html(result);
        });
    });
});