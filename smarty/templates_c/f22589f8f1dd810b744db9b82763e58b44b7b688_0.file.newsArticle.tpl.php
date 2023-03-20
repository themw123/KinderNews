<?php
/* Smarty version 4.2.0, created on 2023-03-20 12:27:11
  from 'C:\xampp\htdocs\Projekte\KinderNews\smarty\templates\newsArticle.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_6418430f2f71c6_20811904',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f22589f8f1dd810b744db9b82763e58b44b7b688' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Projekte\\KinderNews\\smarty\\templates\\newsArticle.tpl',
      1 => 1679311630,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:navbar.tpl' => 1,
  ),
),false)) {
function content_6418430f2f71c6_20811904 (Smarty_Internal_Template $_smarty_tpl) {
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
    <link href="css/newsArticle.css" rel="stylesheet" type="text/css">

</head>

<body>

    <?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="backgr d-flex flex-column justify-content-center align-items-center">
            <div class="bildcontainer container-fluid">
                <img class="bild custom-shadow" src=<?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["bild_url"];?>
 class="card-img-top" alt=""
                    onerror="this.onerror=null; this.src='./img/empty.png'; ">
            </div>

            <p class="ptitle">
                <?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["uebersetzter_titel"];?>

            </p>

            <div class="customContainer custom-shadow-article mx-5 mt-4 mb-4">



                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="ml-3">
                            <img class="me-2" id="changeText" src="./img/document.png"></img>
                        </div>
                        <p class="pinfo">Kind</p>
                        <div class="heartandlikes d-flex mr-4">
                            <div class="mr-1">
                                <?php if ($_smarty_tpl->tpl_vars['liked']->value == true) {?>
                                    <img class="heart" src="./img/heart2.png"></img>
                                <?php } else { ?>
                                    <img class="heart" src="./img/heart1.png"></img>
                                <?php }?>
                            </div>

                            <div class="d-flex align-items-center">
                                <?php if ($_smarty_tpl->tpl_vars['likes']->value == 0) {?>
                                    <div class="likes"></div>
                                <?php } else { ?>
                                    <div class="likes"><?php echo $_smarty_tpl->tpl_vars['likes']->value;?>
</div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>


                <p class="ptext"><?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["uebersetzter_text"];?>
</p>
                <p class="ptextOriginal hidden"><?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["originaler_text"];?>
</p>

            </div>

            <p class="pquestion pquestion1" data-bs-toggle="collapse" href="#answer1"><?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["frage1"];?>
</p>
            <div class="answer collapse mx-2" id="answer1">
                <div class="card card-body mb-4">
                    <?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["answer1"];?>

                </div>
            </div>
            <p class="pquestion pquestion2" data-bs-toggle="collapse" href="#answer2"><?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["frage2"];?>
</p>
            <div class="answer collapse mx-2" id="answer2">
                <div class="card card-body mb-4">
                    <?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["answer2"];?>

                </div>
            </div>
            <p class="pquestion pquestion3" data-bs-toggle="collapse" href="#answer3"><?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["frage3"];?>
</p>
            <div class="answer collapse mx-2" id="answer3">
                <div class="card card-body mb-4">
                    <?php echo $_smarty_tpl->tpl_vars['newsArticle']->value["answer3"];?>

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
 src="js/newsArticle.js"><?php echo '</script'; ?>
>


</body>




</html><?php }
}
