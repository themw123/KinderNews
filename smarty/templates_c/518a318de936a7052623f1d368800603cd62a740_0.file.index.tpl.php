<?php
/* Smarty version 4.2.0, created on 2023-03-09 01:19:08
  from 'C:\xampp\htdocs\Projekte\KinderNews\smarty\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_640925fca964d4_85940901',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '518a318de936a7052623f1d368800603cd62a740' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Projekte\\KinderNews\\smarty\\templates\\index.tpl',
      1 => 1678321146,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./smarty/templates/not_loggedIn.tpl' => 1,
  ),
),false)) {
function content_640925fca964d4_85940901 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML>
<html>

<head>
    <title>Anmelden</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="css/not_loggedIn.css" rel="stylesheet" type="text/css">
</head>

<body>


    <?php $_smarty_tpl->_subTemplateRender("file:./smarty/templates/not_loggedIn.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <?php echo '<script'; ?>
 src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/not_loggedIn.js"><?php echo '</script'; ?>
>


</body>




</html><?php }
}
