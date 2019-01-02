$().ready(function () {
   $('.confirm-delete-button').click(function () {
       let id = $( this ).data('id');

       formData.append('id', id);

       $.ajax({
           method: "POST",
           url: "/admin/rips",
           contentType: false,
           processData: false,
           dataType: 'json',
           date: formData,
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       }).done( function (result) {
           if (result.status === 'ok') {
               $('.confirm-delete-button').remove();
               $('.cancel-delete-button').remove();

               $('.main-content-wrapper').append('<p>Пользователь успешно удален</p>' +
               '<a href="' + result.url + '" class="button confirm-button">Назад</a> ');
           }
       });
   });
});