$().ready(function () {
    let smallNav = $('.small-nav');
    let smallFirstLevel = $('.small-first-level');
    $('.menu-icon-svg').click(function () {
        smallNav.css('display', 'none');
        smallFirstLevel.fadeIn(500);
    });
    $('.small-delete-button').click(function () {
       smallFirstLevel.css('display', 'none');
       smallNav.fadeIn(500);
    });
    $('.small-deleted-item').click(function () {
       smallFirstLevel.css('display', 'none');
       smallNav.fadeIn(500);
    });
});