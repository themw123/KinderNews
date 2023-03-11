<?php
/* Smarty version 4.2.0, created on 2023-03-11 13:45:24
  from 'C:\xampp\htdocs\Projekte\KinderNews\smarty\templates\navbar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_640c77e42597f2_79445646',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '10d3efd03712da657eb63eb537e721c15cc3ff35' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Projekte\\KinderNews\\smarty\\templates\\navbar.tpl',
      1 => 1678538723,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_640c77e42597f2_79445646 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="mb-customNav">
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-auto">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="col d-flex align-items-center justify-content-sm-center justify-content-xs-start titlediv">
                    <a class="navbar-brand" href="./?home">KinderNews</a>
                </div>

                <div class="dropdown col-auto position-relative mt-1 d-none d-sm-block">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle show"
                        data-bs-toggle="dropdown" aria-expanded="true" data-bs-reference="parent">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>

                        <strong><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</strong>

                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow"
                        style="position: absolute; inset: auto auto auto -30px; margin: 0px;"
                        data-popper-placement="bottom-start">
                        <li><a class="dropdown-item" href="<?php echo $_smarty_tpl->tpl_vars['profile']->value;?>
">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php echo $_smarty_tpl->tpl_vars['login_or_logout_link']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['login_or_logout']->value;?>
</a></li>
                    </ul>
                </div>


            </div>
            <div class="offcanvas offcanvas-start text-bg-dark pl-2 pr-4 pb-4 pt-2" tabindex="-1"
                id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Navigationsleiste</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" id="nav-home" aria-current="page" href="./?home">Startseite</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-news" href="./?news">News</a>
                        </li>
                    </ul>
                </div>
                <div class="d-sm-none d-block pl-2 pr-4 pb-4 pt-2 ">
                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                            <strong><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow"
                            style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(0px, -33.6px, 0px);"
                            data-popper-placement="top-end">
                            <li><a class="dropdown-item" href="<?php echo $_smarty_tpl->tpl_vars['profile']->value;?>
">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href=<?php echo $_smarty_tpl->tpl_vars['login_or_logout_link']->value;?>
><?php echo $_smarty_tpl->tpl_vars['login_or_logout']->value;?>
</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div><?php }
}
