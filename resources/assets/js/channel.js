$().ready(function () {
    let id = $('.channel').data('id');
    if (id) {
        window.Echo.private('user.' + id)
            .listen('MessageSaved', (e) => {
                console.log(e.message.text);
                window.messages.push({
                    'message': e.message.text,
                    'user_to': {
                        'id': e.user_to.id,
                        'username': e.user_to.username
                    },
                    'user_from': {
                        'id': e.user_from.id,
                        'username': e.user_from.username
                    }
                });
            })
            .listen('FriendRequest', (e) => {
                let friendRequests = $('.friend-requests');

                let requests = friendRequests.html();

                requests = parseInt(requests);

                requests+=requests;

                friendRequests.html('+' + requests);

                $('.users-element-request:last').after('<li class="users-element-request">' +
                    '<a href="'+ e.urlSender +'" class="profile-link"><img src="'+ e.avatar +'" class="avatar-image"></a>' +
                    '<a href="'+ e.urlSender +'" class="profile-name">'+ e.sender.username +'</a>' +
                    '<div class="friend-request-button right" data-id="'+ e.sender.id +'" data-username="'+ e.friend.username +'">' +
                    '<svg version="1.1" class="public-user-uncheck" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381;" xml:space="preserve">' +
                    '<g>' +
                    '<path d="M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65' +
                    'c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305' +
                    'c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73' +
                    'c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z"></path>' +
                    '</g>' +
                    '</svg>' +
                    '</div>' +
                    '</li>');
            })
            .listen('ConfirmFriendRequest', (e) => {
                let id = e.sender.id;
                let classFriend = '.friend-id-' + id;

                $(classFriend).children().last().replaceWith('<div class="confirmed right">' +
                    '<svg version="1.1" class="checked-friend-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">' +
                    '<path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>' +
                    '</svg>' +
                    '</div>')
            })
    }
});