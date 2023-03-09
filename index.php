<?php
require_once("./includes/startTemplate.inc.php");
$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

if ($REQUEST_METHOD == "GET") {
	if (isset($_GET["home"])) {
		$template = 'home.tpl';
	} else if (isset($_GET["news"])) {
		$template = 'news.tpl';
	} else {
		$template = 'home.tpl';
	}
} else {
}


$smarty->display($template);
