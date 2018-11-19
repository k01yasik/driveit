$().ready(function () {
    $('.text-editor-body').keydown(function (e) {
        if (e.ctrlKey && e.keyCode === 13) {
            let dataElement = $('.profile-block-content');
            let username = dataElement.data('username');
            let friend_id = dataElement.data('friend');
            let editor = $('.text-editor-body');
            let message = editor.html();
            editor.html('<div><br /></div>');
            localStorage.removeItem('post-body');

            let formData = new FormData();
            formData.append('username', username);
            formData.append('friend_id', friend_id);
            formData.append('message', message);

            $.ajax({
                method: "POST",
                url: "/user/messages/store",
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (result) {
                let data = '<div class="message-wrapper">' +
                    '<div class="message-header">' +
                    '<a href="'+ result.url +'" class="message-header-link"><img src="'+ result.avatar +'" class="message-header-avatar"></a>' +
                    '</div>' +
                    '<div class="message-body">' +
                    '<div class="message-body-header">' +
                    '<a href="'+ result.url +'" class="message-header-name">'+ result.username +'</a>' +
                    '<div class="message-body-header-time">'+ result.time +'</div>' +
                    '</div>' +
                    '<div class="message-body-content">' +
                    result.text +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('.profile-block-content').append(data);
            });
        }
    });
});