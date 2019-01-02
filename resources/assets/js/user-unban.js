$().ready(function () {
   $('.unban-user-button').click(function () {
       let id = $( this ).data('id');

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
             $( this ).remove();
             $('.user-info').append('<div class="button info-button right">Разблокирован</div>');
           }
       });
   });
});