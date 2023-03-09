<?php
/* Smarty version 4.2.0, created on 2023-03-09 19:37:50
  from 'C:\xampp\htdocs\Projekte\KinderNews\smarty\templates\navbar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_640a277ec7e8d6_51796271',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '10d3efd03712da657eb63eb537e721c15cc3ff35' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Projekte\\KinderNews\\smarty\\templates\\navbar.tpl',
      1 => 1678387070,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_640a277ec7e8d6_51796271 (Smarty_Internal_Template $_smarty_tpl) {
?><nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-auto">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="col d-flex align-items-center justify-content-sm-center justify-content-xs-start titlediv">
                <a class="navbar-brand" href="#">KinderNews</a>
            </div>
        </div>
        <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" id="nav-home" aria-current="page" href="./?home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-news" href="./authentication.php?news">News</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav><?php }
}
