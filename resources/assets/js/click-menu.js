$().ready(function() {
    $('.expanded-item').click(function() {
       $(this).next().toggle();
    });
});