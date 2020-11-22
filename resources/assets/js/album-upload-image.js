let element = $('#upload_image_to_album_input');

$('.add-image-button').click(function () {
    element.click();
});

element.change(function () {

    $('.image-progress').fadeIn(500);

    let images = element.prop('files');
    let album_name = element.data('name');
    let username = element.data('username');

    let formData = new FormData();

    for (let x = 0; x < images.length; x++) {
        formData.append('images_upload[]', images[x]);
    }

    formData.append('album_name', album_name);
    formData.append('username', username);

    $.ajax({
        xhr: function() {
            let xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    let percentComplete = evt.loaded / evt.total * 100;

                    let roundPercent = Math.round(percentComplete);

                    $('.image-progress').prop('value', roundPercent);
                }
            }, false);

            return xhr;
        },
        method: "POST",
        url: "/user/albums/image/upload",
        contentType: false,
        processData: false,
        dataType: 'json',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (result) {
        $('.no-images').hide();

        let progress = $('.image-progress');

        progress.fadeOut(100);
        progress.prop('value', 0);

        result.forEach(function (res) {
            let wrapper = $('.image-wrapper');
            if (wrapper.css('display') === 'none') {
                wrapper.css('display', 'flex');
            }

            wrapper.prepend('<div class="image-block">'+
                '<div class="image-block-top">' +
                '<div class="image-block-top-button" data-id="'+ res[2] +'" data-username="' + res[3] + '" data-album="'+ res[4] +'">' +
                '<svg version="1.1" class="image-block-button-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 94.926 94.926" style="enable-background:new 0 0 94.926 94.926;"' +
                'xml:space="preserve">' +
                '<g>' +
                '<path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0' +
                'c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096' +
                'c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476' +
                'c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62' +
                's1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"></path>' +
                '</g>' +
                '</svg>' +
                '</div>' +
                '</div>' +
                '<img src="' + res[1] + '" /><div class="image-block-footer"><div class="image-block-footer-counter">0</div>' +
                '<div class="image-block-footer-wrapper">' +
                '<div class="image-block-footer-button" data-id="' + res[2] +'" data-username="' + res[3] +'">' +
                '<svg version="1.1" class="heart-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">' +
                '<g>' +
                '<path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55 ' +
                'C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"></path>' +
                '</g>' +
                '</svg>' +
                '</div>' +
                '</div>' +
                '</div></div>');
        });
    });
});