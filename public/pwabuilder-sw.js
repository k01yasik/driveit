const CACHE = "web-rookie-cache";

const offlineFallbackPage = "offline.html";

self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open(CACHE).then(function (cache) {
            return cache.add(offlineFallbackPage);
        })
    );
});

self.addEventListener("activate", function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (CACHE !== cacheName) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

self.addEventListener("fetch", function (event) {
    if (event.request.method !== "GET") return;

    if ( event.request.url.indexOf( '/socket.io/' ) !== -1 ) {
        return false;
    }

    if ( event.request.url.indexOf( 'chrome-extension' ) !== -1 ) {
        return false;
    }

    if ( event.request.url.indexOf( 'googletagmanager' ) !== -1 ) {
        return false;
    }
    if ( event.request.url.indexOf( 'metrika' ) !== -1 ) {
        return false;
    }
    if ( event.request.url.indexOf( 'google-analytics' ) !== -1 ) {
        return false;
    }


    event.respondWith(
        fetch(event.request)
            .then(function (response) {
                event.waitUntil(updateCache(event.request, response.clone()));
                return response;
            })
            .catch(function (error) {
                return fromCache(event.request);
            })
    );
});

function fromCache(request) {
    return caches.open(CACHE).then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (!matching || matching.status === 404) {
                if (request.destination !== "document" || request.mode !== "navigate") {
                    return Promise.reject("no-match");
                }
                return cache.match(offlineFallbackPage);
            }
            return matching;
        });
    });
}

function updateCache(request, response) {
    return caches.open(CACHE).then(function (cache) {
        return cache.put(request, response);
    });
}