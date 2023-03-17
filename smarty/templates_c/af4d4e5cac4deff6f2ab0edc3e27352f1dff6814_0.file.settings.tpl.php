<?php
/* Smarty version 4.2.0, created on 2023-03-17 18:38:43
  from 'C:\xampp\htdocs\Projekte\KinderNews\smarty\templates\settings.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_6414a5a3990471_61065312',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'af4d4e5cac4deff6f2ab0edc3e27352f1dff6814' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Projekte\\KinderNews\\smarty\\templates\\settings.tpl',
      1 => 1679072785,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:navbar.tpl' => 1,
  ),
),false)) {
function content_6414a5a3990471_61065312 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML>
<html>

<head>
    <title>KinderNews</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Für iphones. Sonnst ist über der Navbar der Hintergrund Rot. -->
    <meta name="theme-color" content="#2e2c2a" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="css/alle.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/settings.css" rel="stylesheet" type="text/css">

</head>

<body>

    <?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div class="container d-flex justify-content-center align-items-center h-100">


        <div class="col-md-5 mx-auto mt-5">
            <div class="alert alert-hidden">leer</div>

            <div class="card text-bg-light custom-shadow rounded-4 mb-4">
                <div class="card-header fs-5 fw-bold">Einstellungen</div>
                <div class="card-body d-flex flex-column">
                    <div>
                        <div class="d-flex flex-row align-items-center">
                            <p class="customFontSize pe-3 fw-bold">Benutzername: </p>
                            <p class="customFontSize"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</p>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <p class="customFontSize pe-3 fw-bold">Email: </p>
                            <p class="customFontSize"><?php echo $_smarty_tpl->tpl_vars['email']->value;?>
</p>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <p class="customFontSize pe-3 fw-bold">Rolle: </p>
                            <p class="customFontSize"><?php echo $_smarty_tpl->tpl_vars['admin']->value;?>
</p>
                        </div>


                        <div class="card text-bg-light">
                            <div class="card-header">News aktualisieren</div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <p class="text-center customFontSize">Achtung! Es werden die neusten News (maximal 10)
                                    geladen und
                                    anschließend
                                    übersetzt. Nur Administratoren sind berechtigt. Dieser Vorgang kann mehrere Minuten
                                    dauern.
                                </p>
                                <button class="btn btn-dark loadingButton" type="button" <?php echo $_smarty_tpl->tpl_vars['buttonState']->value;?>
>
                                    <span class="spinner-border spinner-border-sm buttonSpinner" role="status"
                                        aria-hidden="true"></span>
                                    <div class="buttonText">aktualisieren</div>
                                </button>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
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
 src="js/navbar.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/settings.js"><?php echo '</script'; ?>
>


</body>




</html><?php }
}
