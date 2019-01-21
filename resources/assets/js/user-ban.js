$().ready(function () {
   $('.confirm-delete-button').click(function () {
       let id = $( this ).data('id');
       let message = $( this ).data('message');
       let button = $( this ).data('button');

       let formData = new FormData();
       formData.append('id', id);

       $.ajax({
           method: "POST",
           url: "/admin/rips",
           contentType: false,
           processData: false,
           dataType: 'json',
           data: formData,
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       }).done( function (result) {
           if (result.status === 'ok') {
               $('.confirm-delete-button').remove();
               $('.cancel-delete-button').remove();

               $('.main-content-wrapper').append('<p>' + message + '</p>' +
               '<a href="' + result.url + '" class="button confirm-button">' + button + '</a> ');
           }
       });
   });
});