$().ready(function() {
    $('.expanded-item').click(function() {
        let elem = $(this);
        elem.next().toggle(200, function () {
            elem.children('.caret-down').toggleClass('rotate-svg');;
        });
    });
});