<script>
    if ("serviceWorker" in navigator) {
        if (navigator.serviceWorker.controller) {

        } else {
            navigator.serviceWorker
                .register("pwabuilder-sw.js", {
                    scope: "./"
                });
        }
    }
</script>