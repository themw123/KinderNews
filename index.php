<?php
require_once("./config.php");
require_once("./includes/startTemplate.inc.php");
require_once("./klassen/DbFunctions.inc.php");
require_once("./klassen/Login.inc.php");
require_once('./libraries/PHPMailer.php');
require_once("./klassen/Register.inc.php");
require_once("./klassen/Reset.inc.php");

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

$login = new Login();
$link = DbFunctions::connectWithDatabase();

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
	$erfolg = DbFunctions::activateAccount($link, $token);
	if ($erfolg) {
		$smarty->assign('messages', "Dein Konto wurde erfolgreich aktiviert! Logge dich jetzt ein.");
	} else {
		$smarty->assign('messages', "Fehler.");
	}
} else if (isset($_POST["resetMail"]) || isset($_POST["resetPassword"])) {
	$reset = new Reset();
	if (isset($_POST["resetPassword"])) {
		$token = $link->real_escape_string(strip_tags($_POST['token'], ENT_QUOTES));
		//hier noch mit zweiten vergleichen!!!!!!!!!!!!!!!!!
		$password = $link->real_escape_string(strip_tags($_POST['password'], ENT_QUOTES));
		$password_repeat = $link->real_escape_string(strip_tags($_POST['password_repeat'], ENT_QUOTES));
		if ($password != $password_repeat) {
			$smarty->assign('messages', "Die Passwörter stimmen nicht überein!");
		} else {
			$password_hash = password_hash($password, PASSWORD_ARGON2ID);
			$erfolg = DbFunctions::resetPassword($link, $password_hash, $token);
			if ($erfolg) {
				$smarty->assign('messages', "Dein Passwort wurde erfolgreich geändert! Logge dich jetzt ein.");
			} else {
				$smarty->assign('messages', "Fehler.");
			}
		}
	}
} else if (isset($_GET["resetPassword"])) {
	$smarty->assign("resetPassword", "resetPassword");
	$token = $link->real_escape_string(strip_tags($_GET['token'], ENT_QUOTES));
	$smarty->assign("token", $token);
} else if (isset($_POST["register"])) {
	$register = new Register();
}

if (isset($login)) {
	if ($login->getErrors() != null) {
		$smarty->assign('errors', $login->getErrors());
	} else if ($login->getMessages() != null) {
		$smarty->assign('messages', $login->getMessages());
	}
}
if (isset($register)) {
	if ($register->getErrors() != null) {
		$smarty->assign('errors', $register->getErrors());
	} else if ($register->getMessages() != null) {
		$smarty->assign('messages', $register->getMessages());
	}
} else if (isset($reset)) {
	if ($reset->getErrors() != null) {
		$smarty->assign('errors', $reset->getErrors());
	} else if ($reset->getMessages() != null) {
		$smarty->assign('messages', $reset->getMessages());
	}
}



if ($login->isUserLoggedIn()) {
	$template = 'loggedIn.tpl';
} else {
	$template = 'not_loggedIn.tpl';
}
$smarty->display($template);
