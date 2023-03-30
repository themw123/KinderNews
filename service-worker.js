if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('service-worker.js')
      .then(function(registration) {
        console.log('Service Worker registered with scope:', registration.scope);
      }, function(err) {
        console.log('Service Worker registration failed:', err);
      });
  });
}


const cacheName = 'meine-pwa-cache';
const filesToCache = [

];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(cacheName)
      .then(function(cache) {
        return cache.addAll(filesToCache);
      })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        if (response) {
          return response;
        }
        return fetch(event.request);
      })
  );
});








//push

// Funktion zum Anfordern der Benachrichtigungsberechtigung
function requestNotificationPermission() {
  // Überprüfen, ob die Browser-Plattform die Notification-API unterstützt
  if ('Notification' in window) {
    Notification.requestPermission().then(permission => {
      if (permission === 'granted') {
        console.log('Benachrichtigungsberechtigung erteilt');
      } else {
        console.warn('Benachrichtigungsberechtigung nicht erteilt');
      }
    });
  }
}

// Ereignis-Handler-Funktion, die auf eine Benutzeraktion reagiert und die Funktion zum Anfordern der Benachrichtigungsberechtigung aufruft
function handleNotificationPermission() {
  // Überprüfen, ob der Browser die Notification-API unterstützt
  if ('Notification' in window) {
    // Überprüfen, ob der Benutzer bereits die Benachrichtigungsberechtigung erteilt hat
    if (Notification.permission === 'granted') {
      console.log('Benachrichtigungsberechtigung erteilt');
      sendNotification(); // Hier wird die Push-Benachrichtigung geplant
    } else {
      // Anfordern der Benachrichtigungsberechtigung
      requestNotificationPermission();
    }
  }
}

// Funktion zum Senden der Push-Benachrichtigung
function sendNotification() {
  const notificationTitle = 'Zeit für KinderNews!';
  const notificationOptions = {
    body: 'Es reich mit TikTok! Zeit für die neusten KinderNews!',
    icon: '/img/app.png',
    vibrate: [200, 100, 200, 100, 200, 100, 200]
  };
  self.registration.showNotification(notificationTitle, notificationOptions);
}


setInterval(sendNotification, 60000);


//wait for doc to load
document.addEventListener('DOMContentLoaded', function() {
  document.querySelector('.navbar-toggler-icon').addEventListener('click', handleNotificationPermission);
});
// Aufruf der Funktionen zum Anfordern der Benachrichtigungsberechtigung und zum Planen der Push-Benachrichtigung
//requestNotificationPermission();
//scheduleNotification();



