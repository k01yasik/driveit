$().ready(function () {
   $('.image-block-top-button').click(function () {
       let element = $( this );
      let id = element.data('id');
      let username = element.data('username');
      let album = element.data('album');
      let path = element.data('path');
      let thumbnail = element.data('thumbnail');


       $.ajax({
           method: "DELETE",
           url: "/user/image/delete" + '?' + $.param({id: id, username: username, album: album, path: path, thumbnail: thumbnail}),
           contentType: false,
           processData: false,
           dataType: 'text',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       }).done( function (result) {
           if (result === 'ok') {
               element.parent().parent().remove();
           }
       });
   });
});