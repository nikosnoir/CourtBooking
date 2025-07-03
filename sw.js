self.addEventListener('install', event => {
    event.waitUntil(
        caches.open('court-static-v1').then(cache => {
            return cache.addAll([
                'index.html',
                'style.css',
                'app.js',
                'court-icons/takraw.svg',
                'court-icons/futsal.svg',
                'court-icons/volleyball.svg'
            ]);
        })
    );
    self.skipWaiting();
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(resp => {
            return resp || fetch(event.request);
        })
    );
});
