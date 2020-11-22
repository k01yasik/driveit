$('.request-list').on('click', '.friend-request-button', function () {
   let element = $( this );
  let id = element.data('id');
  let username = element.data('username');

   let formData = new FormData();
   formData.append('id', id);
   formData.append('username', username);

   $.ajax({
       method: "POST",
       url: "/user/friends/requests",
       contentType: false,
       processData: false,
       dataType: 'text',
       data: formData,
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   }).done(function (result) {
       element.html('<svg version="1.1" class="public-user-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">' +
           '<path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>' +
           '</svg>');

       let friendRequests = $('.friend-requests');

        let requests = friendRequests.html();

        requests = parseInt(requests);

        requests = requests - 1;

        let parentElement = element.parent();

        if (requests > 0) {
            parentElement.fadeOut(500, function () {
                parentElement.remove();
            });
            friendRequests.html('+' + requests);
        } else {
            friendRequests.fadeOut(500);
            parentElement.fadeOut(500, function () {
                $('.request-list-element').fadeIn(500);
            });
        }
   });
});