<?php
/* Smarty version 4.3.4, created on 2023-10-27 23:24:36
  from '/var/www/html/smarty/templates/home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_653c46b471b370_21305786',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f7d10f1315ea5e5f1a9b5a29f177ec880e926ccc' => 
    array (
      0 => '/var/www/html/smarty/templates/home.tpl',
      1 => 1698447538,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:navbar.tpl' => 1,
  ),
),false)) {
function content_653c46b471b370_21305786 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>

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
  <link href="css/home.css?v=2.1" rel="stylesheet" type="text/css">




</head>

<body>
  <?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

  <div class="pb-3">


    <section class="above-the-fold">
      <div class="container d-flex flex-column justify-content-center align-items-center gap-5">
        <h1 class="text-center">Einfache Schlagzeilen!</h1>
        <p class="text-center">Willkommen auf KinderNews! Hier werden komplexe Erwachsenen-News in
          kinderfreundliche News übsersetzen. Dabei wird der Inhalt zusammengefasst, sodass ihr auch ohne mühseliges
          durchlesen von zu langen News up to date bleibt!</p>
        <a href="?news" id="news-link" class="cta-btn">zu den News</a>
      </div>
    </section>



    <section id="about">
      <div class="pad">
        <ul>
          <div class="inhalt">
            <li class="inhalt1">
              <h3>Unser Anliegen</h3>
              <p>Mit KinderNews können Kinder Nachrichten lesen, ohne dass sie von den Inhalten überwältigt oder
                überfordert werden.
                KinderNews nutzt modernste Technologien, um Nachrichten aus einer News-API zu beziehen und sie
                mithilfe von
                ChatGPT kinderfreundlich aufzubereiten. Ziel ist es, dass die Informationen des Artikels
                weiterhin vermittelt werden, allerdings soll dies auf eine nicht verstörende Weise und mittels einfacher
                Sprache erfolgen. Das heißt, man bekommt erwachsene News, die auch von
                Kindern verstanden werden
                können!</p>
            </li>
          </div>
          <div class="inhalt inhalt2">

            <li>
              <h3>Features</h3>
              <p>Es soll mittels Fragen unterhalb des Artikels dazu ermutigt werden, noch einmal über das Gelesene
                nachzudenken
                und
                somit die Information noch besser zu verankern. Zudem wird durch ein Klicken auf die Frage, die Antwort
                ersichtlich. Dies soll Verständnisproblemen entgegen wirken. Des Weiteren gibt es die Möglichkeit, eine
                News zu liken. Dadurch ist die News jederzeit in den Favoriten einsehbar, auch wenn diese nicht mehr
                unter den News aufgelistet ist.</p>
            </li>
          </div>

          <div class="inhalt inhalt3">

            <li>
              <h3>Ressourcen</h3>
              <p>Die News-Beiträge werden automatisiert über die API von <a href="https://newsdata.io/"
                  class="cta-btn">newsdata.io</a> bezogen. Dies wird alle 30 Minuten durchgeführt um die 5 neusten News
                zu holen. Anschließend werden die News dann
                in Kinderfreundliche Sprache mithilfe von
                <a href="https://platform.openai.com/docs/guides/gpt" class="cta-btn">ChatGPT</a> übersetzt.
                Die Fragen und Antworten zu der News werden ebenfalls von ChatGPT generiert. Die verwendete
                ChatGPT-Version ist
                gpt-3.5-turbo
                aus dem Jahr 2023.
              </p>
            </li>
          </div>
          <div class="inhalt inhalt4">

            <li class="inhalt2">
              <h3>Herausforderungen</h3>
              <p>Es kann vorkommen, dass eine News Wörter und Sätze enthält, die nicht kindergerecht sind. Dem liegt
                zugrunde, dass gpt-3.5-turbo noch nicht so ausgereift wie gpt-4.0 ist. Aus Kostengründen ist es leider
                nicht möglich gpt-4.0 zu verwenden.
                Es wird jedoch aktiv daran gearbeitet, das Modell durch Fine-tunen zu verbessern, um das Problem
                anzugehen.
                Das braucht jedoch Zeit und Ressourcen.
              </p>
            </li>
          </div>

        </ul>
      </div>

    </section>

    <section id="about-us">
      <div class="container">
        <h2>Das sind wir</h2>

        <div class="team-members ">


          <a href="https://github.com/themw123" class="team-member">
            <img src="img/image1.jpg" alt="Bild von Gründungsmitglied 1">
            <div class="member-details">
              <h4>Marvin Walczak</h4>
              <p class="mb-3">Ausbildung IT und Bachelor Wirtschaftsinformatik</p>
            </div>
          </a>

          <a href="https://github.com/EnnoSessler" class="team-member">
            <img src="img/image4.jpeg" alt="Bild von Gründungsmitglied 2">
            <div class="member-details">
              <h4>Enno Sessler</h4>
              <p>Student Bachelor Wirtschaftsinformatik</p>
            </div>
          </a>

          <a href="https://www.linkedin.com/in/arantza-rodriguez-53745b256" class="team-member">
            <img src="img/image3.jpg" alt="Bild von Gründungsmitglied 2">
            <div class="member-details">
              <h4>Arantza Rodriguez</h4>
              <p class="mb-3">Bachelor Management & Economics</p>
            </div>
          </a>

        </div>
      </div>

    </section>

    <div class="back-button-box">
      <a href="#top" class="back-to-top-btn">Zurück zum Anfang</a>
    </div>
  </div>

  <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="js/navbar.js?v=1.0"><?php echo '</script'; ?>
>
</body>

</html><?php }
}
