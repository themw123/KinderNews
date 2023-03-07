<?php
require_once("./config.php");
require_once("./includes/startTemplate.inc.php");
require_once("./klassen/DbFunctions.inc.php");
require_once("./klassen/Login.inc.php");

$login = new Login();


if (isset($_GET["logout"])) {
	$smarty->display('not_loggedIn.tpl');
	die();
}



/*
if (!isset($_POST["login"]) && !isset($_POST["register"])) {
	if (!isset($_SESSION["csrfToken"])) {
		$_SESSION["csrfToken"] = bin2hex(random_bytes(64));
	}
	$smarty->assign('csrfToken', $_SESSION["csrfToken"]);
} else if (isset($_POST["login"]) || isset($_POST["register"])) {
	if (!isset($_POST["csrfToken"]) || !isset($_SESSION["csrfToken"]) || $_POST["csrfToken"] != $_SESSION["csrfToken"]) {
		unset($_SESSION["csrfToken"]);
		die("CSRF Token ungültig!");
	}
}
*/


if ($login->isUserLoggedIn()) {
	$smarty->display('loggedIn.tpl');
} else {
	if ($login->getErrors() != null) {
		$smarty->assign('errors', $login->geterrors());
	}
	$smarty->display('not_loggedIn.tpl');
}
