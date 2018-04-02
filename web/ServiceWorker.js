/**
 * Check out https://googlechrome.github.io/sw-toolbox/ for
 * more info on how to use sw-toolbox to custom configure your service worker.
 */


'use strict';
importScripts('./js/sw-toolbox.js');

self.toolbox.options.cache = {
  name: 'centor-api-cache'
};

// pre-cache our key assets
self.toolbox.precache(
  [
    './js/bootstrap.min.js'
    
  ]
);

// dynamically cache any other local assets
self.toolbox.router.any('/*', self.toolbox.cacheFirst);

// for any other requests go to the network, cache,
// and then only use that cached resource if your user goes offline
self.toolbox.router.default = self.toolbox.networkFirst;
