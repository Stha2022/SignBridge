const CACHE='signbridge-shell-v13';
const SHELL=['./','./index.html','./style.css','./app.js','./manifest.webmanifest','./assets/signbridge-hand.png','./icons/icon-192.png','./icons/icon-512.png'];
const RUNTIME='signbridge-runtime-v13';
self.addEventListener('install',e=>e.waitUntil(caches.open(CACHE).then(c=>c.addAll(SHELL)).then(()=>self.skipWaiting())));
self.addEventListener('activate',e=>e.waitUntil(caches.keys().then(keys=>Promise.all(keys.filter(k=>![CACHE,RUNTIME].includes(k)).map(k=>caches.delete(k)))).then(()=>self.clients.claim())));
self.addEventListener('fetch',e=>{if(e.request.method!=='GET')return;e.respondWith(caches.match(e.request).then(c=>c||fetch(e.request).then(r=>{const copy=r.clone();if(r.ok)caches.open(RUNTIME).then(cache=>cache.put(e.request,copy));return r}).catch(()=>caches.match('./index.html'))))});
