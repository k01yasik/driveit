(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{179:function(e,a,t){t(180),e.exports=t(272)},180:function(e,a,t){"use strict";t.r(a);t(256);t(181),t(233),t(234),t(235),t(236),t(237),t(238),t(239),t(240),t(241),t(242),t(243),t(244),t(245),t(246),t(247),t(248),t(249),t(250),t(251),t(252),t(253),t(254),t(255)},181:function(e,a,t){"use strict";t.r(a);var n=t(176),s=(t(28),t(202),t(17));t(203),t(206),t(208);window._=t(182);try{window.$=window.jQuery=t(183)}catch(e){}window.axios=t(184),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest",window.axios.defaults.withCredentials=!0;var o=document.head.querySelector('meta[name="csrf-token"]');o?window.axios.defaults.headers.common["X-CSRF-TOKEN"]=o.content:console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"),Object(s.a)(".tippy",{theme:"material",arrow:s.b,duration:500,placement:"right"}),window.io=t(210),window.smartcrop=t(232),window.Echo=new n.a({broadcaster:"socket.io",host:window.location.hostname})},201:function(e,a,t){var n={"./af":29,"./af.js":29,"./ar":30,"./ar-dz":31,"./ar-dz.js":31,"./ar-kw":32,"./ar-kw.js":32,"./ar-ly":33,"./ar-ly.js":33,"./ar-ma":34,"./ar-ma.js":34,"./ar-sa":35,"./ar-sa.js":35,"./ar-tn":36,"./ar-tn.js":36,"./ar.js":30,"./az":37,"./az.js":37,"./be":38,"./be.js":38,"./bg":39,"./bg.js":39,"./bm":40,"./bm.js":40,"./bn":41,"./bn-bd":42,"./bn-bd.js":42,"./bn.js":41,"./bo":43,"./bo.js":43,"./br":44,"./br.js":44,"./bs":45,"./bs.js":45,"./ca":46,"./ca.js":46,"./cs":47,"./cs.js":47,"./cv":48,"./cv.js":48,"./cy":49,"./cy.js":49,"./da":50,"./da.js":50,"./de":51,"./de-at":52,"./de-at.js":52,"./de-ch":53,"./de-ch.js":53,"./de.js":51,"./dv":54,"./dv.js":54,"./el":55,"./el.js":55,"./en-au":56,"./en-au.js":56,"./en-ca":57,"./en-ca.js":57,"./en-gb":58,"./en-gb.js":58,"./en-ie":59,"./en-ie.js":59,"./en-il":60,"./en-il.js":60,"./en-in":61,"./en-in.js":61,"./en-nz":62,"./en-nz.js":62,"./en-sg":63,"./en-sg.js":63,"./eo":64,"./eo.js":64,"./es":65,"./es-do":66,"./es-do.js":66,"./es-mx":67,"./es-mx.js":67,"./es-us":68,"./es-us.js":68,"./es.js":65,"./et":69,"./et.js":69,"./eu":70,"./eu.js":70,"./fa":71,"./fa.js":71,"./fi":72,"./fi.js":72,"./fil":73,"./fil.js":73,"./fo":74,"./fo.js":74,"./fr":75,"./fr-ca":76,"./fr-ca.js":76,"./fr-ch":77,"./fr-ch.js":77,"./fr.js":75,"./fy":78,"./fy.js":78,"./ga":79,"./ga.js":79,"./gd":80,"./gd.js":80,"./gl":81,"./gl.js":81,"./gom-deva":82,"./gom-deva.js":82,"./gom-latn":83,"./gom-latn.js":83,"./gu":84,"./gu.js":84,"./he":85,"./he.js":85,"./hi":86,"./hi.js":86,"./hr":87,"./hr.js":87,"./hu":88,"./hu.js":88,"./hy-am":89,"./hy-am.js":89,"./id":90,"./id.js":90,"./is":91,"./is.js":91,"./it":92,"./it-ch":93,"./it-ch.js":93,"./it.js":92,"./ja":94,"./ja.js":94,"./jv":95,"./jv.js":95,"./ka":96,"./ka.js":96,"./kk":97,"./kk.js":97,"./km":98,"./km.js":98,"./kn":99,"./kn.js":99,"./ko":100,"./ko.js":100,"./ku":101,"./ku.js":101,"./ky":102,"./ky.js":102,"./lb":103,"./lb.js":103,"./lo":104,"./lo.js":104,"./lt":105,"./lt.js":105,"./lv":106,"./lv.js":106,"./me":107,"./me.js":107,"./mi":108,"./mi.js":108,"./mk":109,"./mk.js":109,"./ml":110,"./ml.js":110,"./mn":111,"./mn.js":111,"./mr":112,"./mr.js":112,"./ms":113,"./ms-my":114,"./ms-my.js":114,"./ms.js":113,"./mt":115,"./mt.js":115,"./my":116,"./my.js":116,"./nb":117,"./nb.js":117,"./ne":118,"./ne.js":118,"./nl":119,"./nl-be":120,"./nl-be.js":120,"./nl.js":119,"./nn":121,"./nn.js":121,"./oc-lnc":122,"./oc-lnc.js":122,"./pa-in":123,"./pa-in.js":123,"./pl":124,"./pl.js":124,"./pt":125,"./pt-br":126,"./pt-br.js":126,"./pt.js":125,"./ro":127,"./ro.js":127,"./ru":128,"./ru.js":128,"./sd":129,"./sd.js":129,"./se":130,"./se.js":130,"./si":131,"./si.js":131,"./sk":132,"./sk.js":132,"./sl":133,"./sl.js":133,"./sq":134,"./sq.js":134,"./sr":135,"./sr-cyrl":136,"./sr-cyrl.js":136,"./sr.js":135,"./ss":137,"./ss.js":137,"./sv":138,"./sv.js":138,"./sw":139,"./sw.js":139,"./ta":140,"./ta.js":140,"./te":141,"./te.js":141,"./tet":142,"./tet.js":142,"./tg":143,"./tg.js":143,"./th":144,"./th.js":144,"./tk":145,"./tk.js":145,"./tl-ph":146,"./tl-ph.js":146,"./tlh":147,"./tlh.js":147,"./tr":148,"./tr.js":148,"./tzl":149,"./tzl.js":149,"./tzm":150,"./tzm-latn":151,"./tzm-latn.js":151,"./tzm.js":150,"./ug-cn":152,"./ug-cn.js":152,"./uk":153,"./uk.js":153,"./ur":154,"./ur.js":154,"./uz":155,"./uz-latn":156,"./uz-latn.js":156,"./uz.js":155,"./vi":157,"./vi.js":157,"./x-pseudo":158,"./x-pseudo.js":158,"./yo":159,"./yo.js":159,"./zh-cn":160,"./zh-cn.js":160,"./zh-hk":161,"./zh-hk.js":161,"./zh-mo":162,"./zh-mo.js":162,"./zh-tw":163,"./zh-tw.js":163};function s(e){var a=o(e);return t(a)}function o(e){if(!t.o(n,e)){var a=new Error("Cannot find module '"+e+"'");throw a.code="MODULE_NOT_FOUND",a}return n[e]}s.keys=function(){return Object.keys(n)},s.resolve=o,e.exports=s,s.id=201},233:function(e,a){var t=localStorage.getItem("title-post-image-url");if(t){var n="<img src="+t+" class='uploaded-image' />";$(".block-wrapper").after(n),$("#image").val(t)}$(".post_upload_image_button").click((function(){$("#post_upload_image_input").click()})),$("#post_upload_image_input").change((function(){var e=$("#image").val(),a=localStorage.getItem("title-post-image-path");if(""!==e)$.ajax({method:"DELETE",url:"/admin/posts/image-destroy?"+$.param({url:e,path:a}),contentType:!1,processData:!1,dataType:"text",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(){var e=$("#post_upload_image_input")[0].files[0],a=new FormData;a.append("post_upload",e),e&&$.ajax({method:"POST",url:"/admin/posts/image-upload",contentType:!1,processData:!1,dataType:"text",data:a,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(e){$(".uploaded-image").remove();var a="<img src="+e+" class='uploaded-image' />";$(".block-wrapper").after(a),$("#image").val(e),localStorage.setItem("title-post-image-url",e.url),localStorage.setItem("title-post-image-path",e.path)}))}));else{var t=$("#post_upload_image_input")[0].files[0],n=new FormData;n.append("post_upload",t),t&&$.ajax({method:"POST",url:"/admin/posts/image-upload",contentType:!1,processData:!1,dataType:"text",data:n,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(e){var a="<img src="+e+" class='uploaded-image' />";$(".block-wrapper").after(a),$("#image").val(e),localStorage.setItem("title-post-image-url",e)}))}}))},234:function(e,a){var t=$(".text-editor-body"),n=$(".select-item-sub"),s=$(".image-select-item-sub"),o=$(".select-item-input"),r=$(".image-select-item-input"),c=$(".image-item"),i=$("#upload_image_form_input"),l=localStorage.getItem("post-body");"undefined"!==l&&null!==l&&t.html(l),"undefined"!==t&&setInterval((function(){localStorage.setItem("post-body",t.html())}),1e4);var d=$("#body").val();""!==d&&t.html(d);var m=function(){if(null!=savedRange)if(window.getSelection){var e=window.getSelection();e.rangeCount>0&&e.removeAllRanges(),e.addRange(savedRange)}else document.createRange?window.getSelection().addRange(savedRange):document.selection&&savedRange.select()};$(".link-item").mouseenter((function(){n.show()})).mouseleave((function(){n.hide()})),c.mouseenter((function(){s.show()})).mouseleave((function(){s.hide()})),$(".delete-item").click((function(){o.val("")})),$(".image-delete-item").click((function(e){e.stopImmediatePropagation(),r.val("")})),s.click((function(e){e.stopImmediatePropagation()})),$(".heading_2").click((function(){t.focus(),m(),document.execCommand("formatBlock",!1,"h2")})),$(".heading_3").click((function(){t.focus(),m(),document.execCommand("formatBlock",!1,"h3")})),$(".paragraph").click((function(){t.focus(),m(),document.execCommand("formatBlock",!1,"p")})),$(".bold-item").click((function(){t.focus(),m(),document.execCommand("bold",!1,null)})),$(".italic-item").click((function(){t.focus(),m(),document.execCommand("italic",!1,null)})),$(".checked-item").click((function(){var e=o.val();o.val(""),n.hide(),t.focus(),m(),document.execCommand("createLink",!1,e)})),$(".image-checked-item").click((function(e){e.stopImmediatePropagation();var a=r.val();if(r.val(""),a){var t=$(".text-editor-body img");0!==t.length&&(t.last().attr("alt",a),s.hide())}})),$(".broken-item").click((function(){t.focus(),m(),document.execCommand("unlink",!1,null)})),$(".ordered-item").click((function(){t.focus(),m(),document.execCommand("insertOrderedList",!1,null)})),$(".unordered-item").click((function(){t.focus(),m(),document.execCommand("insertUnorderedList",!1,null)})),$(".quotes-item").click((function(){t.focus(),m(),document.execCommand("formatBlock",!1,"BLOCKQUOTE")})),$(".indent-item").click((function(){t.focus(),m(),document.execCommand("indent",!1,null)})),$(".outdent-item").click((function(){t.focus(),m(),document.execCommand("outdent",!1,null)})),$(".undo-item").click((function(){t.focus(),m(),document.execCommand("undo",!1,null)})),$(".redo-item").click((function(){t.focus(),m(),document.execCommand("redo",!1,null)})),c.click((function(){i.click()})),i.change((function(){var e=i[0].files[0],a=new FormData;a.append("upload_image_form_input",e);var n=i.data("type");"post"!==n&&"comment"!==n||a.append("type",n);var s=$(".add-comment-wrapper").data("username");s&&a.append("username",s),e&&$.ajax({method:"POST",url:"/user/image/upload",contentType:!1,processData:!1,dataType:"text",data:a,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(e){t.focus(),m(),document.execCommand("insertImage",!1,e)}))})),t.focusout((function(){window.getSelection?savedRange=window.getSelection().getRangeAt(0):document.selection&&(savedRange=document.selection.createRange())})),$(".submit-post-form").click((function(){$("#body").val(t.html()),localStorage.removeItem("post-body"),localStorage.removeItem("title-post-image-url"),$("#create-post-form").submit()})),$(".submit-edit-post-form").click((function(){$("#body").val(t.html()),$("#caption").val("<p>"+$(".text-editor-body").children().first().html()+"</p>"),localStorage.removeItem("post-body"),localStorage.removeItem("title-post-image-url"),$("#create-post-form").submit()}))},235:function(e,a){$(".publish").click((function(e){var a="id="+e.currentTarget.dataset.id;$.ajax({method:"PUT",url:"/admin/posts/publish",data:a,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(){"unpublish-svg"===e.currentTarget.firstElementChild.className.baseVal?e.currentTarget.innerHTML="<svg version='1.1' class='publish-svg' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 26 26' xmlns:xlink='http://www.w3.org/1999/xlink' enable-background='new 0 0 26 26'><path d='m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z'></path></svg>":e.currentTarget.innerHTML="<svg version='1.1' class='unpublish-svg' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 15.381 15.381' style='enable-background:new 0 0 15.381 15.381;' xml:space='preserve'><g><g><path d='M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65 c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305 c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73 c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z'></path></g></g></svg>"}))}))},236:function(e,a){var t=$(".small-nav"),n=$(".small-first-level");$(".menu-icon-svg").click((function(){t.css("display","none"),n.fadeIn(500)})),$(".small-delete-button").click((function(){n.css("display","none"),t.fadeIn(500)})),$(".small-deleted-item").click((function(){n.css("display","none"),t.fadeIn(500)}))},237:function(e,a){$(".rating-block").click((function(e){var a=$(this).data("id"),t=$(this).children("p"),n=new FormData;n.append("id",a),$.ajax({method:"POST",url:"/rating/post",contentType:!1,processData:!1,dataType:"text",data:n,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(e){t.html(e)}))}))},238:function(e,a){var t,n=$(".add-comment-wrapper");$(".add-comment-button").click((function(){var e=$(".text-editor-body"),a=n.data("post"),s=n.data("level"),o=n.data("parent"),r=e.html(),c=new FormData;c.append("post",a),c.append("level",s),c.append("parent",o),c.append("message",r),$.ajax({method:"POST",url:"/comment/store",contentType:!1,processData:!1,dataType:"json",data:c,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(a){localStorage.removeItem("post-body"),e.html("<div><br /></div>");var n="<div class='comment-item level-"+a.level+"' data-level='"+a.level+"'><div class='header'><a href='"+a.url+"' class='user-avatar-link header-item'><img src='"+a.avatar+"' class='user-avatar' alt='"+a.username+"' /></a><a href='"+a.url+"' class='post-author header-item'>"+a.username+"</a><div class='right'>"+a.created_at+"</div></div><div class='body'><p>"+a.message+"</p></div></div>";t?(t.after(n),t=void 0):$(".comments-wrapper").append(n)}))})),$(".reply-button").click((function(){var e=$(this),a=e.data("level");a+=1;var s=e.data("parent");n.data("level",a),n.data("parent",s),$("html, body").animate({scrollTop:$("#add-comment").offset().top},2e3);var o=$(this).parents(".comment-item"),r=o.data("level");for(r+=1;o.next().data("level")>=r;)o=o.next();t=o}))},239:function(e,a){$(".comment-publish-button").click((function(){var e=$(this),a="id="+e.data("id");$.ajax({method:"PUT",url:"/admin/comments/publish",data:a,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(){e.children().hasClass("comment-unpublish-svg")?e.html("<svg version='1.1' class='comment-publish-svg' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 26 26' xmlns:xlink='http://www.w3.org/1999/xlink' enable-background='new 0 0 26 26'><path d='m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z'></path></svg>"):e.html("<svg version='1.1' class='comment-unpublish-svg' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 15.381 15.381' style='enable-background:new 0 0 15.381 15.381;' xml:space='preserve'><g><g><path d='M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65 c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305 c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73 c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z'></path></g></g></svg>")}))}))},240:function(e,a){var t=$("#upload_image_to_album_input");$(".add-image-button").click((function(){t.click()})),t.change((function(){$(".image-progress").fadeIn(500);for(var e=t.prop("files"),a=t.data("name"),n=t.data("username"),s=new FormData,o=0;o<e.length;o++)s.append("images_upload[]",e[o]);s.append("album_name",a),s.append("username",n),$.ajax({xhr:function(){var e=new window.XMLHttpRequest;return e.upload.addEventListener("progress",(function(e){if(e.lengthComputable){var a=e.loaded/e.total*100,t=Math.round(a);$(".image-progress").prop("value",t)}}),!1),e},method:"POST",url:"/user/albums/image/upload",contentType:!1,processData:!1,dataType:"json",data:s,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(e){$(".no-images").hide();var a=$(".image-progress");a.fadeOut(100),a.prop("value",0),e.forEach((function(e){var a=$(".image-wrapper");"none"===a.css("display")&&a.css("display","flex"),a.prepend('<div class="image-block"><div class="image-block-top"><div class="image-block-top-button" data-id="'+e[2]+'" data-username="'+e[3]+'" data-album="'+e[4]+'"><svg version="1.1" class="image-block-button-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 94.926 94.926" style="enable-background:new 0 0 94.926 94.926;"xml:space="preserve"><g><path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"></path></g></svg></div></div><img src="'+e[1]+'" /><div class="image-block-footer"><div class="image-block-footer-counter">0</div><div class="image-block-footer-wrapper"><div class="image-block-footer-button" data-id="'+e[2]+'" data-username="'+e[3]+'"><svg version="1.1" class="heart-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve"><g><path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55 C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"></path></g></svg></div></div></div></div>')}))}))}))},241:function(e,a){$(".image-wrapper").on("click",".image-block-footer-button",(function(){var e=$(this),a=e.data("id"),t=e.data("username"),n=new FormData;n.append("id",a),n.append("username",t),$.ajax({method:"POST",url:"/user/favorite/add",contentType:!1,processData:!1,dataType:"text",data:n,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(a){e.parent().prev().html(a)}))}))},242:function(e,a){$(".image-block-top-button").click((function(){var e=$(this),a=e.data("id"),t=e.data("username"),n=e.data("album"),s=e.data("path"),o=e.data("thumbnail");$.ajax({method:"DELETE",url:"/user/image/delete?"+$.param({id:a,username:t,album:n,path:s,thumbnail:o}),contentType:!1,processData:!1,dataType:"text",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(a){"ok"===a&&e.parent().parent().remove()}))}))},243:function(e,a){$(".request-friend").click((function(){var e=$(this),a=e.data("friend"),t=e.data("username"),n=new FormData;n.append("friend",a),n.append("username",t),$.ajax({method:"POST",url:"/user/friends/add",contentType:!1,processData:!1,dataType:"text",data:n,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(a){e.replaceWith('<div class="waiting right" title="Ожидание подтверждения"><svg version="1.1" class="hourglass-friend-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve"><g><path d="M54,58h-3v-4h-5V43.778c0-2.7-1.342-5.208-3.589-6.706L31.803,30l10.608-7.072C44.658,21.43,46,18.922,46,16.222V6h5V2h3c0.552,0,1-0.447,1-1s-0.448-1-1-1h-3h-1H10H9H6C5.448,0,5,0.447,5,1s0.448,1,1,1h3v4h5v10.222c0,2.7,1.342,5.208,3.589,6.706L28.197,30l-10.608,7.072C15.342,38.57,14,41.078,14,43.778V54H9v4H6c-0.552,0-1,0.447-1,1s0.448,1,1,1h3h1h40h1h3c0.552,0,1-0.447,1-1S54.552,58,54,58z M18.698,21.264C17.009,20.137,16,18.252,16,16.222V6h28v10.222c0,2.03-1.009,3.915-2.698,5.042L30,28.798L18.698,21.264z M16,43.778c0-2.03,1.009-3.915,2.698-5.042L30,31.202l11.302,7.534C42.991,39.863,44,41.748,44,43.778V54H16V43.778z"></path></g></svg></div>')}))}))},244:function(e,a){var t=$(".channel").data("id"),n=$(".full-post").data("id");t&&window.Echo.private("user."+t).listen("MessageSaved",(function(e){var a=$(".profile-block-content");if(a.data("friend")===e.userFrom.id)a.append('<div class="message-wrapper"><div class="message-header"><a href="'+e.url+'" class="message-header-link"><img src="'+e.userFrom.profile.avatar+'" class="message-header-avatar"></a></div><div class="message-body"><div class="message-body-header"><a href="'+e.url+'" class="message-header-name">'+e.userFrom.username+'</a><div class="message-body-header-time">'+e.createdAt+'</div></div><div class="message-body-content">'+e.text+"</div></div></div>");else{var t=$(".messages-count"),n=parseInt(t.html());n+=1,t.html("+"+n),"none"===t.css("display")&&t.fadeIn(500)}})).listen("FriendRequest",(function(e){var a=$(".friend-requests"),t=a.html();t=parseInt(t),t+=t,a.html("+"+t),"none"===a.css("display")&&a.fadeIn(500),$(".users-element-request:last").after('<li class="users-element-request"><a href="'+e.urlSender+'" class="profile-link"><img src="'+e.avatar+'" class="avatar-image"></a><a href="'+e.urlSender+'" class="profile-name">'+e.sender.username+'</a><div class="friend-request-button right" data-id="'+e.sender.id+'" data-username="'+e.friend.username+'"><svg version="1.1" class="public-user-uncheck" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381;" xml:space="preserve"><g><path d="M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z"></path></g></svg></div></li>')})).listen("ConfirmFriendRequest",(function(e){var a=e.sender.id;$(".friend-id-"+a).children().last().replaceWith('<div class="confirmed right"><svg version="1.1" class="checked-friend-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26"><path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path></svg></div>')})),n&&window.Echo.join("post."+n).joining((function(e){$(".article-readers-body").append('<div class="post-reader flex flex-v-center" id="user-'+e.id+'"><a href="'+e.url+'" class="user-avatar-link"><img src="'+e.avatar+'" class="user-avatar" alt="'+e.username+'"></a><a href="'+e.url+'" class="post-author">'+e.username+"</a></div>")})).here((function(e){var a=$(".article-readers-body");0===a.children().length&&e.forEach((function(e){a.append('<div class="post-reader flex flex-v-center" id="user-'+e.id+'"><a href="'+e.url+'" class="user-avatar-link"><img src="'+e.avatar+'" class="user-avatar circle" alt="'+e.username+'"></a><a href="'+e.url+'" class="post-author">'+e.username+"</a></div>")}))})).leaving((function(e){var a="#user-"+e.id;$(a).remove()}))},245:function(e,a){$(".request-list").on("click",".friend-request-button",(function(){var e=$(this),a=e.data("id"),t=e.data("username"),n=new FormData;n.append("id",a),n.append("username",t),$.ajax({method:"POST",url:"/user/friends/requests",contentType:!1,processData:!1,dataType:"text",data:n,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(a){e.html('<svg version="1.1" class="public-user-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26"><path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path></svg>');var t=$(".friend-requests"),n=t.html();n=parseInt(n),n-=1;var s=e.parent();n>0?(s.fadeOut(500,(function(){s.remove()})),t.html("+"+n)):(t.fadeOut(500),s.fadeOut(500,(function(){$(".request-list-element").fadeIn(500)})))}))}))},246:function(e,a){$(".text-editor-body").keydown((function(e){if(e.ctrlKey&&13===e.keyCode){var a=$(".profile-block-content"),t=a.data("username"),n=a.data("friend"),s=$(".text-editor-body"),o=s.html();s.html("<div><br /></div>"),localStorage.removeItem("post-body");var r=new FormData;r.append("username",t),r.append("friend_id",n),r.append("message",o),$.ajax({method:"POST",url:"/user/messages/store",contentType:!1,processData:!1,dataType:"json",data:r,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(e){var a=$(".welcome-chat");"block"===a.css("display")&&a.fadeOut(200);var t='<div class="message-wrapper"><div class="message-header"><a href="'+e.url+'" class="message-header-link"><img src="'+e.avatar+'" class="message-header-avatar circle"></a></div><div class="message-body"><div class="message-body-header"><a href="'+e.url+'" class="message-header-name">'+e.username+'</a><div class="message-body-header-time">'+e.time+'</div></div><div class="message-body-content">'+e.text+"</div></div></div>";$(".profile-block-content").append(t)}))}}))},247:function(e,a){var t=$(".back-to-top");$(window).scroll((function(){var e=document.body.scrollTop,a=document.documentElement.scrollTop;(e>a?e:a)>500?"0"===t.css("opacity")&&(t.css("opacity",1),t.css("z-index",1e3)):"1"===t.css("opacity")&&(t.css("opacity",0),t.css("z-index",-100))})),t.click((function(){$("html, body").animate({scrollTop:0},$(window).scrollTop()/2+2e3)}))},248:function(e,a){$(".upload-button").click((function(){$("#change-avatar-input").click()})),$("#change-avatar-input").change((function(){var e=$("#change-avatar-input")[0].files[0];if(e){var a=new FormData;a.append("avatar_upload",e),a.append("username",$(this).data("username"));var t,n,s=new Image;s.src=URL.createObjectURL(e),s.onload=function(){t=s.height,n=s.width,console.log(n),console.log(t),URL.revokeObjectURL(s.src);var o=new Image(n,t);o.src=URL.createObjectURL(e),console.log(o.width),console.log(o.height),smartcrop.crop(o,{width:200,height:200}).then((function(e){a.append("x",e.topCrop.x),a.append("y",e.topCrop.y),a.append("height",e.topCrop.height),a.append("width",e.topCrop.width),URL.revokeObjectURL(o.src),$.ajax({method:"POST",url:"/user/avatar/upload",contentType:!1,processData:!1,dataType:"text",data:a,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(e){$(".avatar-inner img").attr("src",e)}))}))}}}))},249:function(e,a){$(".confirm-delete-button").click((function(){var e=$(this).data("id"),a=$(this).data("message"),t=$(this).data("button"),n=new FormData;n.append("id",e),$.ajax({method:"POST",url:"/admin/rips",contentType:!1,processData:!1,dataType:"json",data:n,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(e){"ok"===e.status&&($(".main-content-wrapper .flex").hide(),$(".main-content-wrapper").append('<div class="flex flex-justify-space"><p class="lockout-message">'+a+'</p><a href="'+e.url+'" class="button confirm-button">'+t+"</a></div>"))}))}))},250:function(e,a){$(".unban-user-button").click((function(){var e=$(this),a=e.data("id"),t=e.data("message");$.ajax({method:"DELETE",url:"/admin/rips?"+$.param({id:a}),contentType:!1,processData:!1,dataType:"text",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done((function(a){"ok"===a&&(e.remove(),$(".user-info").append('<div class="button info-button right">'+t+"</div>"))}))}))},251:function(e,a){if("undefined"!=typeof posts){var t=$("#postChart"),n=$("#commentsChart"),s=$("#usersChart"),o=$("#countryChart"),r=$("#cityChart"),c=[],i=[];posts.forEach((function(e){switch(e.month){case 1:e.month="Январь";break;case 2:e.month="Февраль";break;case 3:e.month="Март";break;case 4:e.month="Апрель";break;case 5:e.month="Май";break;case 6:e.month="Июнь";break;case 7:e.month="Июль";break;case 8:e.month="Август";break;case 9:e.month="Сентябрь";break;case 10:e.month="Октябрь";break;case 11:e.month="Ноябрь";break;case 12:e.month="Декабрь"}})),posts.forEach((function(e){c.push(e.month+" "+e.year),i.push(e.count)})),i.forEach((function(e){e}));new Chart(t,{type:"bar",data:{labels:c,datasets:[{label:"Количество опубликованных статей",data:i,backgroundColor:"#573EA4",datalabels:{color:"#FFFFFF"}}]},options:{scales:{yAxes:[{ticks:{beginAtZero:!0}}]}}}),commentsVerified,commentsNotVerified,new Chart(n,{type:"doughnut",data:{labels:["Одобренные комментарии","Неодобренные комментарии"],datasets:[{data:[commentsVerified,commentsNotVerified],backgroundColor:["#573EA4","#EF4747"],datalabels:{color:"#FFFFFF"}}]}}),new Chart(s,{type:"line",data:{labels:datesQuery,datasets:[{label:"Количество пользователей",data:usersQuery,backgroundColor:"#573EA4",borderColor:"#573EA4",fill:"origin",datalabels:{display:!1}},{label:"Количество сессий",data:sessionQuery,backgroundColor:"#EF4747",borderColor:"#EF4747",fill:"origin",datalabels:{display:!1}},{label:"Количество взаимодействий",data:hitsQuery,backgroundColor:"#BF3985",borderColor:"#BF3985",fill:"origin",datalabels:{display:!1}}]},options:{scales:{yAxes:[{ticks:{beginAtZero:!0}}]}}}),new Chart(o,{type:"doughnut",data:{labels:countryQueryLabels,datasets:[{data:countryQueryData,backgroundColor:["#EF4747","#EFD247","#573EA4","#39BF39","#EF9347","#EFEF47","#7A369F","#2B8F8F","#EFB747","#ABDF43","#BF3985","#3C5AA0"],datalabels:{color:"#FFFFFF"}}]}}),new Chart(r,{type:"doughnut",data:{labels:cityQueryLabels,datasets:[{data:cityQueryData,backgroundColor:["#EF4747","#EFD247","#573EA4","#39BF39","#EF9347","#EFEF47","#7A369F","#2B8F8F","#EFB747","#ABDF43"],datalabels:{color:"#FFFFFF"}}]}})}},252:function(e,a){$(".image-block").click((function(){var e=$("img",this).data("url");$("main").append("<div class='fullpage-block'><img class='fullpage-image' src='"+e+"' /><div class='fullpage-messges'></div></div>")}))},253:function(e,a){$(".alert").fadeOut(5e3)},254:function(e,a){$(".expanded-item").click((function(){var e=$(this);e.next().toggle(200,(function(){e.children(".caret-down").toggleClass("rotate-svg")}))}))},255:function(e,a){$(".test-airlock").click((function(){axios.get("/api/user").then((function(e){console.log(e.data.slug)})).catch((function(e){console.log("Unauthorized")}))}))},272:function(e,a){}},[[179,1,2]]]);