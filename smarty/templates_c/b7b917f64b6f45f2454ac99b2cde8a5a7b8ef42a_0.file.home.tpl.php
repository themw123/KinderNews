<?php
/* Smarty version 4.3.1, created on 2023-06-15 16:54:32
  from '/var/www/html/iksy05/KinderNews/smarty/templates/home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_648b2628d03c74_35960944',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b7b917f64b6f45f2454ac99b2cde8a5a7b8ef42a' => 
    array (
      0 => '/var/www/html/iksy05/KinderNews/smarty/templates/home.tpl',
      1 => 1686840870,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:navbar.tpl' => 1,
  ),
),false)) {
function content_648b2628d03c74_35960944 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  
  
  <title>Landing Page</title>
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
  <?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <section class="above-the-fold">
      <div class="container">
        <h1>Kleine Schlagzeilen!</h1>
        <p>Holen Sie sich die neuesten Nachrichten auf unterhaltsame und leicht verständliche Weise!</p>
        <a href="<?php echo $_smarty_tpl->tpl_vars['login_or_logout_link']->value;?>
#signup" id="register-link" class="cta-btn">Registrieren</a>
        <a href="<?php echo $_smarty_tpl->tpl_vars['login_or_logout_link']->value;?>
" class="cta-btn">Log-In</a>

      </div>
    </section>

    

   <section id="about">
  <ul>
    <li>
      <h3>Unser Anliegen</h3>
      <p>Bei uns können Kinder Nachrichten lesen, ohne dass sie von Inhalten überwältigt oder überfordert werden. Unsere Website nutzt modernste Technologie, um Nachrichten aus der API zu beziehen und sie mithilfe von ChatGPT kinderfreundlich aufzubereiten. Uns ist es wichtig, dass die Informationen des Artikels weiterhin transportiert werden, sie jedoch auf eine nicht verstörende Weise in einfacherem Sprachgebrauch wiedergegeben werden.</p>
    </li>
    <li>
      <h3>Unser Ziel</h3>
      <p>Unser Ziel ist es, Kindern die Möglichkeit zu geben, Nachrichten zu lesen und diese auch zu verstehen. Außerdem regen wir mit Fragen unterhalb des Artikels dazu an, noch einmal über das Gelesene nachzudenken und somit die Information noch besser zu verankern.</p>
    </li>
    <li>
      <h3>Unsere Quellen</h3>
      <p>Unsere News-Beiträge beziehen wir automatisiert über die API von <a href="https://newsdata.io/" class="cta-btn">newsdata.io</a>. In kinderfreundliche Sprache werden sie dann mithilfe einer Abfrage an <a href="https://platform.openai.com/docs/guides/gpt" class="cta-btn">ChatGPT</a> übersetzt. Zudem generieren wir automatisch Fragen zum Artikel mithilfe von ChatGPT. Die verwendete ChatGPT-Version ist "gpt-3.5-turbo" aus dem Jahr 2023.</p>
    </li>
  </ul>
</section>

<section id="about-us">
  <div class="container">
    <h2>Das sind wir</h2>
    <div class="team-members">
      <div class="team-member">
      <a href="https://github.com/themw123">
        <img src="img/image1.jpg" alt="Bild von Gründungsmitglied 1">
        </a>
        <div class="member-details">
          <h4>Marvin Walczak</h4>
          <p>Student Bachelor Wirtschaftsinformatik</p>
        </div>
      </div>
      <div class="team-member">
      <a href="https://github.com/EnnoSessler">
        <img src="img/image2.jpg" alt="Bild von Gründungsmitglied 2">
        </a>
        <div class="member-details">
          <h4>Enno Sessler</h4>
          <p>Student Bachelor Wirtschaftsinformatik</p>
        </div>
      </div>
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
 src="js/notloggedin.js?v=1.0"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/navbar.js?v=1.0"><?php echo '</script'; ?>
>
  </body>
</html><?php }
}
