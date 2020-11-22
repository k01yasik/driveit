$('.unban-user-button').click(function () {
   let element = $( this );
   let id = element.data('id');
   let message = element.data('message');

   $.ajax({
       method: "DELETE",
       url: "/admin/rips" + '?' + $.param({id: id}),
       contentType: false,
       processData: false,
       dataType: 'text',
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   }).done( function (result) {
       if (result === 'ok') {
         element.remove();
         $('.user-info').append('<div class="button info-button right">' + message + '</div>');
       }
   });
});