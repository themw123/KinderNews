<!DOCTYPE html>

<head>


  <title>KinderNews</title>
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Für iphones. Sonnst ist über der Navbar der Hintergrund Rot. -->
  <meta name="theme-color" content="#2e2c2a" />
  <link rel="manifest" href="/manifest.json">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="css/alle.css" rel="stylesheet" type="text/css">
  <link href="css/navbar.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/home.css" type="text/css">




</head>

<body>
  {include file="navbar.tpl"}

  <div class="pb-3">


    <section class="above-the-fold">
      <div class="container d-flex flex-column justify-content-center align-items-center">
        <h1 class="text-center">Kleine Schlagzeilen!</h1>
        <p class="text-center h1sub">Hole dir die neuesten Nachrichten auf unterhaltsame und leicht verständliche
          Weise!
        </p>
        <a href="?news" id="news-link" class="cta-btn">zu den News</a>
      </div>
    </section>



    <section id="about">
      <div class="pad">
        <div class="container inhalt">
          <ul>
            <li>
              <h3>Unser Anliegen</h3>
              <p>Bei uns können Kinder Nachrichten lesen, ohne dass sie von Inhalten überwältigt oder überfordert
                werden.
                Unsere Website nutzt modernste Technologie, um Nachrichten aus der API zu beziehen und sie mithilfe von
                ChatGPT kinderfreundlich aufzubereiten. Uns ist es wichtig, dass die Informationen des Artikels
                weiterhin
                transportiert werden, sie jedoch auf eine nicht verstörende Weise in einfacherem Sprachgebrauch
                wiedergegeben
                werden.</p>
            </li>
            <li>
              <h3>Unser Ziel</h3>
              <p>Unser Ziel ist es, Kindern die Möglichkeit zu geben, Nachrichten zu lesen und diese auch zu verstehen.
                Außerdem regen wir mit Fragen unterhalb des Artikels dazu an, noch einmal über das Gelesene nachzudenken
                und
                somit die Information noch besser zu verankern.</p>
            </li>
            <li>
              <h3>Unsere Quellen</h3>
              <p>Unsere News-Beiträge beziehen wir automatisiert über die API von <a href="https://newsdata.io/"
                  class="cta-btn">newsdata.io</a>. In kinderfreundliche Sprache werden sie dann mithilfe einer Abfrage
                an
                <a href="https://platform.openai.com/docs/guides/gpt" class="cta-btn">ChatGPT</a> übersetzt. Zudem
                generieren
                wir automatisch Fragen zum Artikel mithilfe von ChatGPT. Die verwendete ChatGPT-Version ist
                "gpt-3.5-turbo"
                aus dem Jahr 2023.
              </p>
            </li>
          </ul>
        </div>
      </div>

    </section>

    <section id="about-us">
      <div class="container">
        <h2>Das sind wir</h2>

        <div class="team-members">

          <a href="https://github.com/EnnoSessler" class="team-member">
            <img src="img/image2.jpg" alt="Bild von Gründungsmitglied 2">
            <div class="member-details">
              <h4>Enno Sessler</h4>
              <p>Student Bachelor Wirtschaftsinformatik</p>
            </div>
          </a>

          <a href="https://github.com/themw123" class="team-member">
            <img src="img/image1.jpg" alt="Bild von Gründungsmitglied 1">
            <div class="member-details">
              <h4>Marvin Walczak</h4>
              <p>Student Bachelor Wirtschaftsinformatik</p>
            </div>
          </a>

          <div class="team-member">
            <img src="img/image4.jpeg" alt="Bild von Gründungsmitglied 3">
            <div class="member-details">
              <h4>Luke Eßkuchen</h4>
              <p>Student Bachelor Wirtschaftsinformatik</p>
            </div>
          </div>

          <div class="team-member">
            <img src="img/image3.jpg" alt="Bild von Gründungsmitglied 4">
            <div class="member-details">
              <h4>Dennis Sadovoi</h4>
              <p>Student Bachelor Wirtschaftsinformatik</p>
            </div>
          </div>
        </div>
      </div>

    </section>

    <div class="back-button-box">
      <a href="#top" class="back-to-top-btn">Zurück zum Anfang</a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
  </script>
  <script src="js/navbar.js?v=1.0"></script>
</body>

</html>