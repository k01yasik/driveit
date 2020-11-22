let editor = $('.text-editor-body');

let selectItemSub = $('.select-item-sub');
let imageSelectItemSub = $('.image-select-item-sub');
let selectItemInput = $('.select-item-input');
let imageSelectItemInput = $('.image-select-item-input');
let imageItem = $('.image-item');
let upload_image = $('#upload_image_form_input');

let textPostBody = localStorage.getItem('post-body');

if (textPostBody !== "undefined" && textPostBody !== null) {
    editor.html(textPostBody)
}

if (editor !== "undefined") {
    setInterval(function () {
        localStorage.setItem('post-body', editor.html())
    }, 10000);
}

let bodyText = $('#body').val();
if (bodyText !== "") {
    editor.html(bodyText);
}

let restoreSelection = function () {
    if (savedRange != null) {
        if (window.getSelection)
        {
            let s = window.getSelection();
            if (s.rangeCount > 0)
                s.removeAllRanges();
            s.addRange(savedRange);
        }
        else if (document.createRange)
        {
            window.getSelection().addRange(savedRange);
        }
        else if (document.selection) //IE
        {
            savedRange.select();
        }
    }
};

let saveSelection = function () {
    if (window.getSelection)
    {
        savedRange = window.getSelection().getRangeAt(0);
    }
    else if (document.selection) //IE
    {
        savedRange = document.selection.createRange();
    }
};

$('.link-item').mouseenter(function () {
    selectItemSub.show();
}).mouseleave(function () {
    selectItemSub.hide();
});

imageItem.mouseenter(function () {
    imageSelectItemSub.show();
}).mouseleave(function () {
   imageSelectItemSub.hide();
});

$('.delete-item').click(function () {
   selectItemInput.val('');
});

$('.image-delete-item').click(function (e) {
    e.stopImmediatePropagation();
    imageSelectItemInput.val('');
});

imageSelectItemSub.click(function (e) {
   e.stopImmediatePropagation();
});

$('.heading_2').click(function () {
    editor.focus();

    restoreSelection();

    document.execCommand('formatBlock', false, 'h2');
});
$('.heading_3').click(function () {
    editor.focus();

    restoreSelection();

    document.execCommand('formatBlock', false, 'h3');
});
$('.paragraph').click(function () {
    editor.focus();

    restoreSelection();

    document.execCommand('formatBlock', false, 'p');
});

$('.bold-item').click(function () {
    editor.focus();

    restoreSelection();

    document.execCommand("bold", false, null);
});

$('.italic-item').click(function () {
   editor.focus();

   restoreSelection();

   document.execCommand("italic", false, null);
});

$('.checked-item').click(function () {
    let input = selectItemInput.val();
    selectItemInput.val('');

    selectItemSub.hide();

    editor.focus();

    restoreSelection();

    document.execCommand('createLink', false, input);
});

$('.image-checked-item').click(function (e) {
    e.stopImmediatePropagation();
    let input = imageSelectItemInput.val();
    imageSelectItemInput.val('');

    if (input) {
        let images = $('.text-editor-body img');

        let images_len = images.length;

        if (images_len !== 0) {
            images.last().attr('alt', input);
            imageSelectItemSub.hide();
        }
    }
});

$('.broken-item').click(function () {
   editor.focus();

   restoreSelection();

   document.execCommand('unlink', false, null);
});

$('.ordered-item').click(function () {
   editor.focus();

   restoreSelection();

   document.execCommand('insertOrderedList', false, null);
});

$('.unordered-item').click(function () {
   editor.focus();

   restoreSelection();

   document.execCommand('insertUnorderedList', false, null);
});

$('.quotes-item').click(function () {
   editor.focus();

   restoreSelection();

   document.execCommand('formatBlock', false, 'BLOCKQUOTE');
});

$('.indent-item').click(function () {
   editor.focus();

   restoreSelection();

   document.execCommand('indent', false, null);
});

$('.outdent-item').click(function () {
   editor.focus();

   restoreSelection();

   document.execCommand('outdent', false, null);
});

$('.undo-item').click(function () {
   editor.focus();

   restoreSelection();

   document.execCommand('undo', false, null);
});

$('.redo-item').click(function () {
    editor.focus();

    restoreSelection();

    document.execCommand('redo', false, null);
});

imageItem.click(function () {
    upload_image.click();
});

upload_image.change(function () {
   let selectedFile = upload_image[0].files[0];

   let formData = new FormData();
   formData.append('upload_image_form_input', selectedFile);

   let type = upload_image.data('type');

   if (type === 'post' || type === 'comment') {
       formData.append('type', type);
   }

   let username = $('.add-comment-wrapper').data('username');

   if (username) {
       formData.append('username', username);
   }

    if (selectedFile) {

        $.ajax({
            method: "POST",
            url: "/user/image/upload",
            contentType: false,
            processData: false,
            dataType: 'text',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (result) {

            editor.focus();

            restoreSelection();

            document.execCommand('insertImage', false, result);

        });

    }
});

editor.focusout(function () {
    saveSelection();
});

$('.submit-post-form').click(function () {
   $('#body').val(editor.html());
   localStorage.removeItem('post-body');
   localStorage.removeItem('title-post-image-url');
   $('#create-post-form').submit();
});

$('.submit-edit-post-form').click(function () {
    $('#body').val(editor.html());
    $('#caption').val('<p>' + $('.text-editor-body').children().first().html() + '</p>');
    localStorage.removeItem('post-body');
    localStorage.removeItem('title-post-image-url');
    $('#create-post-form').submit();
});