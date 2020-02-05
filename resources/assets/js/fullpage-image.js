$().ready(function(){
   $('.image-block').click(function() {
      let url = $("img", this).data('url');
       $("main").append("<div class='fullpage-block'><img class='fullpage-image' src='" + url + "' /><div class='fullpage-messges'></div></div>");
   });
});