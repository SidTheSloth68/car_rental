// Service Worker for Car Rental Application
// Version 1.0.0

const CACHE_NAME = 'car-rental-v1.0.0';
const urlsToCache = [
    '/',
    '/css/style.css',
    '/css/bootstrap.min.css',
    '/js/plugins.js',
    '/js/designesia.js',
    '/images/logo.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-512x512.png',
    '/manifest.json'
];

// Install event
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
});

// Fetch event
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                // Return cached version or fetch from network
                if (response) {
                    return response;
                }
                return fetch(event.request);
            })
    );
});

// Activate event
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Background sync for offline bookings
self.addEventListener('sync', event => {
    if (event.tag === 'background-sync') {
        event.waitUntil(doBackgroundSync());
    }
});

async function doBackgroundSync() {
    // Handle offline booking submissions
    const bookings = await getOfflineBookings();
    for (const booking of bookings) {
        try {
            await fetch('/api/v1/bookings', {
                method: 'POST',
                body: JSON.stringify(booking),
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            await removeOfflineBooking(booking.id);
        } catch (error) {
            console.log('Failed to sync booking:', error);
        }
    }
}

async function getOfflineBookings() {
    // Implement offline storage retrieval
    return [];
}

async function removeOfflineBooking(id) {
    // Implement offline storage removal
    return true;
}