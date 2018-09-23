$().ready(function () {
    if (window.location.hash && window.location.hash === '#_=_') {
        if (window.history && history.pushState) {
            console.log('working');
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
});