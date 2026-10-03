const CACHE_NAME = 'lapor-jalan-v3';

const urlsToCache = [
    '/',
    '/manifest.json'
];

self.addEventListener('install', event => {

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );

    self.skipWaiting();
});

self.addEventListener('activate', event => {

    event.waitUntil(
        caches.keys().then(cacheNames => {

            return Promise.all(
                cacheNames
                    .filter(name => name !== CACHE_NAME)
                    .map(name => caches.delete(name))
            );

        })
    );

    self.clients.claim();
});

self.addEventListener('fetch', event => {

    // Jangan intercept POST/PUT/PATCH/DELETE
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .catch(() => caches.match(event.request))
    );

});

// ===============================
// PUSH NOTIFICATION
// ===============================

self.addEventListener('push', event => {

    let data = {};

    if (event.data) {
        try {
            data = event.data.json();
        } catch (error) {
            data = {
                title: 'Lapor Jalan Wonogiri',
                body: event.data.text()
            };
        }
    }

    const title = data.title || 'Lapor Jalan Wonogiri';

    const options = {
        body: data.body || 'Ada informasi terbaru.',
        icon: '/icons/icon-192.png',
        badge: '/icons/icon-192.png',
        data: {
            url: data.data?.url || data.url || '/'
        }
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );

});


// ===============================
// KLIK NOTIFIKASI
// ===============================

self.addEventListener('notificationclick', event => {

    event.notification.close();

    const targetUrl =
        event.notification.data?.url || '/';

    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then(clientList => {

            for (const client of clientList) {

                if ('focus' in client) {
                    client.navigate(targetUrl);
                    return client.focus();
                }

            }

            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }

        })
    );

});