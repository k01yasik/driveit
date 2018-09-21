$().ready(function () {
    if (window.location.hash) {
        if ( window.location.hash === '#_=_' || window.location.hash === '#') {
            if (window.history && history.pushState) {
                window.history.pushState("", document.title, window.location.pathname);
            } else {
                let scroll = {
                    top: document.body.scrollTop,
                    left: document.body.scrollLeft
                };
                window.location.hash = '';

                document.body.scrollTop = scroll.top;
                document.body.scrollLeft = scroll.left;
            }
        }
    }
});