<?php
require_once("./klassen/Login.inc.php");

require_once("./includes/startTemplate.inc.php");
$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];


$login = new Login(null);


if ($REQUEST_METHOD == "GET") {
	if (isset($_GET["home"])) {
		$template = 'home.tpl';
	}
	/*
	else if (isset($_GET["news"])) {
		//nicht erlaubt. Route erfolgt über authentication.php
		//$template = 'news.tpl';
	} */ else {
		$template = 'home.tpl';
	}
} else {
}


if ($login->isUserLoggedIn()) {
	$name = $_SESSION["name"];
	$login_or_logout = "Logout";
	$login_or_logout_link = "./authentication.php?logout";
	$profile = "./authentication.php?profile";
} else {
	$name = "";
	$login_or_logout = "Login";
	$login_or_logout_link = "./authentication.php";
	$profile = "./authentication.php";
}
$smarty->assign("name", $name);
$smarty->assign("login_or_logout", $login_or_logout);
$smarty->assign("login_or_logout_link", $login_or_logout_link);
$smarty->assign("profile", $profile);
$smarty->display($template);
