$().ready(function () {
    $('.rating-block').click(function(e){

        let id = $( this ).data('id');
        let paragraph = $( this ).children('p');

        let formData = new FormData();
        formData.append('id', id);

        $.ajax({
            method: "POST",
            url: "/rating/post",
            contentType: false,
            processData: false,
            dataType: 'text',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (result) {
            paragraph.html(result);
        });
    });
});