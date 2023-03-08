<?php
require_once("./config.php");
require_once("./includes/startTemplate.inc.php");
require_once("./klassen/DbFunctions.inc.php");
require_once("./klassen/Login.inc.php");

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

$login = new Login();

//loggedOutBefore damit Token neu generiert wird und nicht das alte Token genommen wird.
if ($REQUEST_METHOD == "GET") {
	if (!isset($_SESSION["csrfToken"]) || isset($_SESSION["loggedOutBefore"])) {
		$_SESSION["csrfToken"] = bin2hex(random_bytes(64));
		$smarty->assign('csrfToken', $_SESSION["csrfToken"]);
	}
} else {
	if (!isset($_POST["csrfToken"]) || !isset($_SESSION["csrfToken"]) || $_POST["csrfToken"] != $_SESSION["csrfToken"]) {
		unset($_SESSION["csrfToken"]);
		die("CSRF Token ungültig!");
	}
}

if ($login->isUserLoggedIn()) {
	$smarty->display('loggedIn.tpl');
} else {
	if ($login->getErrors() != null) {
		$smarty->assign('errors', $login->geterrors());
	}
	$smarty->display('not_loggedIn.tpl');
}
