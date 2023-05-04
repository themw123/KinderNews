<?php
/* Smarty version 4.2.0, created on 2023-05-04 16:01:14
  from 'C:\xampp\htdocs\Projekte\KinderNews\smarty\templates\home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_6453baaa3abd09_92833677',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9ca37f772a7c9ef0f093b18e6023fdc88994221' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Projekte\\KinderNews\\smarty\\templates\\home.tpl',
      1 => 1683208869,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:navbar.tpl' => 1,
  ),
),false)) {
function content_6453baaa3abd09_92833677 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML>
<html>



<link href="css/alle.css" rel="stylesheet" type="text/css">
<link href="css/navbar.css" rel="stylesheet" type="text/css">
<link href="css/home.css" rel="stylesheet" type="text/css">

<?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<body>
    <p>Home!!!!!!</p>
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
 src="js/home.js"><?php echo '</script'; ?>
>


</body>




</html><?php }
}
