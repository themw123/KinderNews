<?php
require_once("./config.php");
require_once("./includes/startTemplate.inc.php");
require_once("./klassen/DbFunctions.inc.php");
require_once("./klassen/Login.inc.php");
require_once('./libraries/PHPMailer.php');
require_once("./klassen/Register.inc.php");

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




$smarty->assign('csrfToken', $_SESSION["csrfToken"]);

if (isset($_GET["confirm"])) {
	$token = $_GET['token'];
	$link = DbFunctions::connectWithDatabase();
	DbFunctions::activateAccount($link, $token);
	$smarty->assign('messages', "Dein Konto wurde erfolgreich aktiviert! Logge dich jetzt ein.");
} else if (isset($_POST["reset"])) {
	$test = "";
} else if (isset($_POST["register"])) {
	$register = new Register();
}

if (isset($register)) {
	if ($register->getErrors() != null) {
		$smarty->assign('errors', $register->getErrors());
	} else if ($register->getMessages() != null) {
		$smarty->assign('messages', $register->getMessages());
	}
} else if (isset($login)) {
	if ($login->getErrors() != null) {
		$smarty->assign('errors', $login->getErrors());
	} else if ($login->getMessages() != null) {
		$smarty->assign('messages', $login->getMessages());
	}
}



if ($login->isUserLoggedIn()) {
	$template = 'loggedIn.tpl';
} else {
	$template = 'not_loggedIn.tpl';
}
$smarty->display($template);
