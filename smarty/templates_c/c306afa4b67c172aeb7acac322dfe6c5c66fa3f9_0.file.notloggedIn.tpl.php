<?php
/* Smarty version 4.2.0, created on 2023-03-12 23:50:07
  from 'C:\xampp\htdocs\Projekte\KinderNews\smarty\templates\notloggedIn.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_640e571f925dd9_28895702',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c306afa4b67c172aeb7acac322dfe6c5c66fa3f9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Projekte\\KinderNews\\smarty\\templates\\notloggedIn.tpl',
      1 => 1678661407,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:navbar.tpl' => 1,
  ),
),false)) {
function content_640e571f925dd9_28895702 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML>
<html>

<head>
    <title>KinderNews</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- 4.0.0 zusätzlich nötig, da wir login frontend mit 4.0.0 gemacht haben-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href="css/alle.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/notLoggedIn.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div>
        <?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
    <div class="container d-flex justify-content-center align-items-center h-100">
        <div class="col-md-5 mx-auto mb-5 mt-5">
            <?php if (!(isset($_smarty_tpl->tpl_vars['errors']->value)) && !(isset($_smarty_tpl->tpl_vars['messages']->value))) {?>
                <div class="alert alert-hidden">leer</div>
            <?php }?>

            <?php if (((isset($_smarty_tpl->tpl_vars['errors']->value)))) {?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors']->value, 'error');
$_smarty_tpl->tpl_vars['error']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->do_else = false;
?>
                    <?php if (($_smarty_tpl->tpl_vars['error']->value != false)) {?>
                        <div class="alert alert-warning"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div>
                    <?php }?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php }?>
            <?php if (((isset($_smarty_tpl->tpl_vars['messages']->value)))) {?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['messages']->value, 'message');
$_smarty_tpl->tpl_vars['message']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['message']->value) {
$_smarty_tpl->tpl_vars['message']->do_else = false;
?>
                    <div class="alert alert-custom"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php }?>


            <div id="ohneFourth">
                <div id="first">
                    <div class="myform form custom-shadow">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1>Anmelden</h1>
                            </div>
                        </div>
                        <form action="" method="post" name="login">
                            <input type="hidden" name="csrfToken" value="<?php echo $_smarty_tpl->tpl_vars['csrfToken']->value;?>
" />
                            <div class="form-group">
                                <label>Email oder Benutzer</label>
                                <input type="text" name="email_or_user" class="form-control" id="email_or_user"
                                    aria-describedby="email_or_user_Help" placeholder="Eingabe Email oder Benutzername"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Passwort</label>
                                <input type="password" name="password" id="password" minlength="6" class="form-control"
                                    aria-describedby="passwordHelp" placeholder="Eingabe Passwort" required>
                            </div>
                            <div class="col-md-12 text-center ">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm"
                                    name="login">Login</button>
                            </div>
                            <div class="col-md-12 ">
                                <div class="login-or">
                                    <hr class="hr-or">
                                    <span class="span-or">oder</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="text-center">Passwort vergessen? <a href="#" id="reset">Hier
                                        zurücksetzten</a>
                                </p>
                            </div>
                            <div class="form-group">
                                <p class="text-center">Noch kein Konto? <a href="#" id="signup">Hier
                                        registrieren</a>
                                </p>
                            </div>
                        </form>

                    </div>
                </div>
                <div id="second">
                    <div class="myform form custom-shadow">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1>Registrieren</h1>
                            </div>
                        </div>
                        <form action="" method="post" name="registration">
                            <input type="hidden" name="csrfToken" value="<?php echo $_smarty_tpl->tpl_vars['csrfToken']->value;?>
" />
                            <div class="form-group">
                                <label>Benutzername</label>
                                <input type="text" name="username" class="form-control" id="username"
                                    aria-describedby="usernameHelp" placeholder="Eingabe Benutzername" required>
                            </div>
                            <div class="form-group">
                                <label>Email Addresse</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    aria-describedby="emailHelp" placeholder="Eingabe Email" required>
                            </div>
                            <div class="form-group">
                                <label>Passwort</label>
                                <input type="password" name="password" id="passwordRegister1" minlength="6"
                                    class="form-control" aria-describedby="passwordHelp" placeholder="Eingabe Passwort"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Passwort wiederholen</label>
                                <input type="password" name="password_repeat" id="passwordRegister2" minlength="6"
                                    class="form-control" aria-describedby="passwordHelp" placeholder="Eingabe Passwort"
                                    required>
                            </div>
                            <div class="col-md-12 text-center mb-3">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm"
                                    name="register">Registrieren</button>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <p class="text-center"><a href="#" id="signin">Du hast bereits ein
                                            Konto?</a>
                                    </p>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
                <div id="third">
                    <div class="myform form custom-shadow">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1 class="resetpassword">Passwort zurücksetzen</h1>
                            </div>
                        </div>
                        <form action="" method="post" name="resetMail">
                            <input type="hidden" name="csrfToken" value="<?php echo $_smarty_tpl->tpl_vars['csrfToken']->value;?>
" />
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    aria-describedby="email" placeholder="Eingabe Email " required>
                            </div>
                            <div class="col-md-12 text-center mb-3">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm"
                                    name="resetMail">Email
                                    senden</button>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <p class="text-center"><a href="#" id="signinMail_reset">zurück zum
                                            login</a>
                                    </p>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>

            <div id="fourth" style="display: none;">
                <div class="myform form custom-shadow">
                    <div class="logo mb-3">
                        <div class="col-md-12 text-center">
                            <h1>Passwort zurücksetzen</h1>
                        </div>
                    </div>
                    <form action="?backToLogin" method="post" name="resetPassword">
                        <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" />
                        <input type="hidden" name="csrfToken" value="<?php echo $_smarty_tpl->tpl_vars['csrfToken']->value;?>
" />
                        <div class="form-group">
                            <label>Passwort neu</label>
                            <input type="password" name="password" id="passwordReset1" minlength="6"
                                class="form-control" aria-describedby="passwordHelp" placeholder="Eingabe Passwort neu"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Passwort wiederholen</label>
                            <input type="password" name="password_repeat" id="passwordReset2" minlength="6"
                                class="form-control" aria-describedby="passwordHelp"
                                placeholder="Eingabe Passwort erneut" required>
                        </div>
                        <div class="col-md-12 text-center mb-3">
                            <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm"
                                name="resetPassword">zurücksetzen</button>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <p class="text-center"><a href="#" id="signinPassword_reset">zurück
                                        zum
                                        login</a>
                                </p>
                            </div>
                        </div>
                </div>
                </form>
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
 src="js/notLoggedIn.js"><?php echo '</script'; ?>
>


</body>




</html><?php }
}
