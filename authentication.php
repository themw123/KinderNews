<?php
require_once("./config.php");
require_once("./includes/startTemplate.inc.php");
require_once("./klassen/Logs.inc.php");
require_once("./klassen/DbFunctions.inc.php");
require_once("./klassen/Login.inc.php");
require_once('./libraries/PHPMailer.php');
require_once('./klassen/Mail.inc.php');
require_once("./klassen/Register.inc.php");
require_once("./klassen/Reset.inc.php");


$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
$link = DbFunctions::connectWithDatabase();

$login = new Login($link);
$register = new Register($link);
$reset = new Reset($link);

if (isset($_GET["resetPassword"])) {
	$smarty->assign("resetPassword", "resetPassword");
	$token = Reset::resetPasswordFrontend();
	$smarty->assign("token", $token);
}

//loggedOutBefore damit Token neu generiert wird und nicht das alte Token genommen wird.
if ($REQUEST_METHOD == "GET") {
	if (!isset($_SESSION["csrfToken"]) || isset($_SESSION["loggedOutBefore"])) {
		$_SESSION["csrfToken"] = bin2hex(random_bytes(64));
	}
} else {
	if (!isset($_POST["csrfToken"]) || !isset($_SESSION["csrfToken"]) || $_POST["csrfToken"] != $_SESSION["csrfToken"]) {
		unset($_SESSION["csrfToken"]);
		die("CSRF Token ungültig!");
	}
}
$smarty->assign('csrfToken', $_SESSION["csrfToken"]);


if (Logs::getErrors() != null) {
	$smarty->assign('errors', Logs::getErrors());
} else if (Logs::getMessages() != null) {
	$smarty->assign('messages', Logs::getMessages());
}



if ($login->isUserLoggedIn()) {
	$name = $_SESSION["name"];
	$login_or_logout = "Logout";
	$login_or_logout_link = "./authentication.php?logout";
	$profile = "./authentication.php?profile";
	if (isset($_GET["news"])) {
		//mockdaten
		$news = array(
			"Neue Studie zeigt: Impfung gegen COVID-19 schützt auch vor schweren Verläufen",
			"Forschungserfolg: Wissenschaftler*innen entwickeln künstliche Haut, die Schmerzen empfinden kann",
			"EU-Kommission plant Gesetz zur Eindämmung von Desinformation im Internet",
			"Tesla kündigt Bau von Gigafactory in Deutschland an",
			"Neueröffnung: Berliner Flughafen BER nimmt Betrieb auf"
		);
		$smarty->assign('news', $news);
		$template = 'news.tpl';
	} elseif (isset($_GET["profile"])) {
		$template = 'profile.tpl';
	} else {
		$template = 'home.tpl';
	}
} else {
	$name = "";
	$login_or_logout = "Login";
	$login_or_logout_link = "./authentication.php";
	$profile = "./authentication.php";
	$template = 'notloggedIn.tpl';
}
$smarty->assign("name", $name);
$smarty->assign("login_or_logout", $login_or_logout);
$smarty->assign("login_or_logout_link", $login_or_logout_link);
$smarty->assign("profile", $profile);
$smarty->display($template);
