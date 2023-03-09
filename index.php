<?php
require_once("./includes/startTemplate.inc.php");
$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];



$template = 'index.tpl';

$smarty->display($template);
