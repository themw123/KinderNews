<?php
/* Smarty version 4.3.1, created on 2023-05-11 09:57:39
  from 'C:\xampp\htdocs\Projekte\KinderNews\smarty\templates\news.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_645c9ff3707f90_47068931',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c931ec2f243f5fb1e115d6986829157671427dc0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Projekte\\KinderNews\\smarty\\templates\\news.tpl',
      1 => 1683400959,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:navbar.tpl' => 1,
  ),
),false)) {
function content_645c9ff3707f90_47068931 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML>
<html>

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
    <link href="css/news.css" rel="stylesheet" type="text/css">

</head>

<body>


    <?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div class="custom row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 g-4 mt-1 mb-5">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['news']->value, 'article');
$_smarty_tpl->tpl_vars['article']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->do_else = false;
?>
            <div class="col">
                <a href="./?news&id=<?php echo $_smarty_tpl->tpl_vars['article']->value["id"];?>
">
                    <div class="card border-0 h-100 ">
                        <?php if ($_smarty_tpl->tpl_vars['article']->value["bild_url"] == "error") {?>
                            <img class="bilder rounded-top"
                                src='https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg'
                                class="card-img-top" alt="" onerror="this.src='./img/empty.png'">
                        <?php } else { ?>
                            <img class="bilder rounded-top" src=<?php echo $_smarty_tpl->tpl_vars['article']->value["bild_url"];?>
 class="card-img-top" alt=""
                                onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg'">
                        <?php }?>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text mt-auto"><small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['article']->value["quelle"];?>
</small></p>
                            <h5 class="card-title"><?php echo $_smarty_tpl->tpl_vars['article']->value["uebersetzter_titel"];?>
</h5>
                            <p class="card-text mt-auto"><?php echo $_smarty_tpl->tpl_vars['article']->value["uebersetzte_preview"];?>
</p>
                            <p class="card-text mt-auto"><small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['article']->value["date"];?>
</small></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
 src="js/news.js"><?php echo '</script'; ?>
>


</body>




</html><?php }
}
