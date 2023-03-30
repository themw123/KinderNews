if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/service-worker.js')
      .then(function(registration) {
        console.log('Service Worker registered with scope:', registration.scope);
      }, function(err) {
        console.log('Service Worker registration failed:', err);
      });
  });
}

// setze die Zeit für die erste Benachrichtigung auf die aktuelle Zeit plus 1 Minute
localStorage.setItem('notificationTime', new Date().getTime() + 60 * 1000);

// Timer-Callback, um die Benachrichtigung zu senden
function sendNotification() {
  var notification = new Notification('Titel der Benachrichtigung', {
    body: 'Nachrichteninhalt',
    icon: '/img/app.png'
  });
  
  // aktualisiere die Benachrichtigungszeit auf die nächste Minute
  localStorage.setItem('notificationTime', new Date().getTime() + 60 * 1000);
}

// Timer, um die Benachrichtigung jede Minute zu senden
setInterval(function() {
  var notificationTime = localStorage.getItem('notificationTime');
  
  // wenn die aktuelle Zeit größer oder gleich der Benachrichtigungszeit ist, sende die Benachrichtigung
  if (new Date().getTime() >= notificationTime) {
    sendNotification();
  }
}, 1000); // überprüfe alle 1 Sekunde, ob es Zeit für eine Benachrichtigung ist