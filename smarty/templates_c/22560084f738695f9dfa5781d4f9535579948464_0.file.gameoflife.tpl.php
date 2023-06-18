<?php
/* Smarty version 4.3.1, created on 2023-06-06 15:09:22
  from '/var/www/html/iksy05/KinderNews/smarty/templates/gameoflife.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_647f3002701bc8_36189675',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '22560084f738695f9dfa5781d4f9535579948464' => 
    array (
      0 => '/var/www/html/iksy05/KinderNews/smarty/templates/gameoflife.tpl',
      1 => 1686056957,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:navbar.tpl' => 1,
  ),
),false)) {
function content_647f3002701bc8_36189675 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>
	<title>Game of Life</title>
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
    <link href="css/gameoflife.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 	
 	<table id="grid">
		
    	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['gridRows']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
      	<tr>
      		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value, 'cell');
$_smarty_tpl->tpl_vars['cell']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['cell']->value) {
$_smarty_tpl->tpl_vars['cell']->do_else = false;
?>
      			<td class="<?php if ($_smarty_tpl->tpl_vars['cell']->value) {?>alive<?php }?>" onclick="toggleCellState(this)"></td>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
     	</tr>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	
	</table>
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
 src="js/gameoflife.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="js/navbar.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
