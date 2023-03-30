//Benachrichtigung
let notiRunning = false;

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
    } else {
      // Anfordern der Benachrichtigungsberechtigung
      requestNotificationPermission();
    }
    if(!notiRunning) {
      setInterval(sendNotification, 30000);
      notiRunning = true;
    }
  }
}
/*
// Zeitplan für das Senden der Push-Benachrichtigung jeden Abend um 19 Uhr
function scheduleNotification() {
  const now = new Date();
  const notificationTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 0, 45, 0);
  const timeUntilNotification = notificationTime.getTime() - now.getTime();

  if (timeUntilNotification < 0) {
    // Wenn die aktuelle Uhrzeit bereits nach 19 Uhr ist, wird die Push-Benachrichtigung für den nächsten Tag geplant
    notificationTime.setDate(notificationTime.getDate() + 1);
    timeUntilNotification = notificationTime.getTime() - now.getTime();
  }

  setTimeout(() => {
    sendNotification();
    scheduleNotification();
  }, timeUntilNotification);
}
*/



function sendNotification() {
  const title = 'Zeit für KinderNews!';
  const options = {
    body: 'Es reich mit TikTok! Zeit für die neusten KinderNews!',
    icon: '/img/app.png',
    vibrate: [200, 100, 200, 100, 200, 100, 200]
  };
  new Notification(title, options);
  setTimeout(sendNotification, 30000);
}


// Aufruf der Funktionen zum Anfordern der Benachrichtigungsberechtigung und zum Planen der Push-Benachrichtigung
//requestNotificationPermission();
document.querySelector('.navbar-toggler-icon').addEventListener('click', handleNotificationPermission);
//scheduleNotification();