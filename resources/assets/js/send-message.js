$().ready(function () {
    $('.text-editor-body').keydown(function (e) {
        if (e.ctrlKey && e.keyCode === 13) {
            let dataElement = $('.profile-block-content');
            let username = dataElement.data('username');
            let friend_id = dataElement.data('friend');
            let message = $('.text-editor-body').html();

            let formData = new FormData();
            formData.append('username', username);
            formData.append('friend_id', friend_id);
            formData.append('message', message);

            $.ajax({
                method: "POST",
                url: "/user/messages/store",
                contentType: false,
                processData: false,
                dataType: 'text',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (result) {

            });
        }
    });
});