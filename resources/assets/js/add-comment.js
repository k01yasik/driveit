$().ready(function () {
    let wrapper = $('.add-comment-wrapper');
    let target_element;

    $('.add-comment-button').click(function () {
        let text_editor = $('.text-editor-body');
        /*text_editor.focus();
        document.execCommand('selectAll', false, null);
        document.execCommand('removeFormat', false, null);*/
        let post = wrapper.data('post');
        let level = wrapper.data('level');
        let parent = wrapper.data('parent');
        let message = text_editor.html();

        let formData = new FormData();
        formData.append('post', post);
        formData.append('level', level);
        formData.append('parent', parent);
        formData.append('message', message);

        $.ajax({
            method: "POST",
            url: "/comment/store",
            contentType: false,
            processData: false,
            dataType: 'json',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (result) {

            localStorage.removeItem('post-body');
            text_editor.html('<div><br /></div>');

            let comment_html = "<div class='comment-item level-" + result.level + "' data-level='" + result.level + "'>" +
                               "<div class='header'>" +
                                "<a href='" + result.url + "' class='user-avatar-link header-item'>" +
                                "<img src='" + result.avatar + "' class='user-avatar' alt='" + result.username + "' />" +
                                "</a>" +
                                "<a href='" + result.url + "' class='post-author header-item'>" + result.username + "</a>" +
                                "<div class='right'>" + result.created_at + "</div>" +
                                "</div>" +
                                "<div class='body'>" +
                                "<p>" + result.message + "</p>" +
                                "</div></div>";

            if (target_element) {
                target_element.after(comment_html);
                target_element = undefined;
            } else {
                $('.comments-wrapper').append(comment_html);
            }


        });

    });

    $('.reply-button').click(function () {
        let reply = $(this);
        let level = reply.data('level');
        level+= 1;

        let parent = reply.data('parent');

        wrapper.data('level', level);
        wrapper.data('parent', parent);

        $('html, body').animate({
            scrollTop: $("#add-comment").offset().top
        }, 2000);

        let clicked_parent = $(this).parents('.comment-item');
        let clicked_parent_level = clicked_parent.data('level');
        clicked_parent_level+= 1;

        while (clicked_parent.next().data('level') >= clicked_parent_level) {
            clicked_parent = clicked_parent.next();
        }

        target_element = clicked_parent;

    });


});