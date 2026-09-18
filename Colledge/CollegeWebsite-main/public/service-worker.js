const CACHE_NAME = 'college-website-offline-v2';
const OFFLINE_URL = '/offline.html';

// Ресурсы для offline страницы
const OFFLINE_RESOURCES = [
    OFFLINE_URL,
    '/images/logo45.svg',
    '/images/college-logo.svg'
];

// Установка Service Worker
self.addEventListener('install', (event) => {
    console.log('[ServiceWorker] Installing...');
    
    event.waitUntil(
        (async () => {
            const cache = await caches.open(CACHE_NAME);
            
            // Кешируем offline страницу
            try {
                await cache.add(new Request(OFFLINE_URL, { cache: 'reload' }));
                console.log('[ServiceWorker] Offline page cached');
            } catch (error) {
                console.error('[ServiceWorker] Failed to cache offline page:', error);
            }
            
            // Кешируем дополнительные ресурсы
            try {
                await cache.addAll(OFFLINE_RESOURCES);
                console.log('[ServiceWorker] Additional resources cached');
            } catch (error) {
                console.error('[ServiceWorker] Failed to cache resources:', error);
            }
        })()
    );
    
    // Активируем новый Service Worker сразу
    self.skipWaiting();
});

// Активация Service Worker
self.addEventListener('activate', (event) => {
    console.log('[ServiceWorker] Activating...');
    
    event.waitUntil(
        (async () => {
            // Удаляем старые кеши
            const cacheNames = await caches.keys();
            await Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('[ServiceWorker] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })()
    );
    
    // Берем контроль над всеми клиентами
    return self.clients.claim();
});

// Перехват запросов
self.addEventListener('fetch', (event) => {
    // Игнорируем не-GET запросы
    if (event.request.method !== 'GET') {
        return;
    }
    
    // Игнорируем запросы к админке и API
    const url = new URL(event.request.url);
    if (url.pathname.startsWith('/admin') || 
        url.pathname.startsWith('/livewire') ||
        url.pathname.startsWith('/api')) {
        return;
    }
    
    event.respondWith(
        (async () => {
            try {
                // Пытаемся получить из сети
                const networkResponse = await fetch(event.request);
                
                // Если успешно и это HTML, кешируем
                if (networkResponse.ok && 
                    event.request.destination === 'document') {
                    const cache = await caches.open(CACHE_NAME);
                    cache.put(event.request, networkResponse.clone());
                }
                
                return networkResponse;
                
            } catch (error) {
                // Сеть недоступна
                console.log('[ServiceWorker] Network request failed:', event.request.url);
                
                // Пытаемся получить из кеша
                const cachedResponse = await caches.match(event.request);
                if (cachedResponse) {
                    console.log('[ServiceWorker] Serving from cache:', event.request.url);
                    return cachedResponse;
                }
                
                // Если это навигационный запрос, показываем offline страницу
                if (event.request.destination === 'document' ||
                    event.request.mode === 'navigate' ||
                    (event.request.method === 'GET' && 
                     event.request.headers.get('accept').includes('text/html'))) {
                    
                    console.log('[ServiceWorker] Serving offline page');
                    const cache = await caches.open(CACHE_NAME);
                    const offlineResponse = await cache.match(OFFLINE_URL);
                    
                    if (offlineResponse) {
                        return offlineResponse;
                    }
                }
                
                // Возвращаем базовый offline ответ
                return new Response('Offline - No cached version available', {
                    status: 503,
                    statusText: 'Service Unavailable',
                    headers: new Headers({
                        'Content-Type': 'text/plain'
                    })
                });
            }
        })()
    );
});