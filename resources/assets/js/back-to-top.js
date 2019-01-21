$().ready(function () {
   let back = $('.back-to-top');

   $( window ).scroll(function() {
       const BODY_SCROLL = document.body.scrollTop;
       const ELEMENT_SCROLL = document.documentElement.scrollTop;
       const heightPixels = 500;

       let scrollTop;

       if (BODY_SCROLL > ELEMENT_SCROLL) {
           scrollTop = BODY_SCROLL;
       } else {
           scrollTop = ELEMENT_SCROLL;
       }

       if (scrollTop > heightPixels) {
           if (back.css('opacity') === '0') { back.css('opacity', 1); back.css('z-index', 10); }
       } else {
           if (back.css('opacity') === '1') { back.css('opacity', 0); back.css('z-index', -10); }
       }
   });

   back.click(function() {

       $('html, body').animate({
           scrollTop: 0
       }, $( window ).scrollTop() / 2 + 2000);
   });

});