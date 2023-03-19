<?php

require_once('./vendor/autoload.php');
require_once("./config.php");
require_once("./includes/startTemplate.inc.php");
require_once("./klassen/Logs.inc.php");
require_once("./klassen/DbFunctions.inc.php");
require_once("./klassen/Login.inc.php");
require_once('./libraries/PHPMailer.php');
require_once('./klassen/Mail.inc.php');
require_once("./klassen/Register.inc.php");
require_once("./klassen/Reset.inc.php");
require_once("./klassen/News.inc.php");


$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
$link = DbFunctions::connectWithDatabase();

//session wird in login erzeugt bzw wiederaufgenommen
//die komplette Login logik inklusive register und password reset wird mittels folgender drei klassen erledigt
$login = new Login($link);
$register = new Register($link);
$reset = new Reset($link);

$news = new News($link, $login);

//csrf validierung
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

//error bzw messages anzeigen
if (Logs::getErrors() != null) {
	$smarty->assign('errors', Logs::getErrors());
} else if (Logs::getMessages() != null) {
	$smarty->assign('messages', Logs::getMessages());
}

//route logik
if ($login->isUserLoggedIn()) {
	$name = $_SESSION["name"];
	$login_or_logout = "Logout";
	$login_or_logout_link = "./?logout";
	$settings = "./?settings";
	if (isset($_GET["news"])) {
		if (isset($_GET["id"])) {
			//einzelne news
			$newsArticle = DbFunctions::getNewsArticleDb($link);
			$liked = DbFunctions::checkLike($link, $_GET["id"]);
			$likes = DbFunctions::countLikes($link, $_GET["id"]);
			$smarty->assign('newsArticle', $newsArticle);
			$smarty->assign('liked', $liked);
			$smarty->assign('likes', $likes);
			$template = 'newsArticle.tpl';
		} else {
			//news feed
			//Bei langen Ladezeiten kann Anfrage über js bzw js->php->db->js erfolgen, damit loading circle solange angezeigt wird, bis die Daten da sind.
			$newsArray = DbFunctions::getNewsDb($link);
			$smarty->assign('news', $newsArray);
			$template = 'news.tpl';
		}
	} elseif (isset($_GET["settings"])) {
		$name = $_SESSION["name"];
		$email = $_SESSION["email"];
		$admin = $_SESSION["admin"];
		if ($admin == 1) {
			$admin = "Administrator";
			$buttonState = "";
		} else {
			$admin = "Standardbenutzer";
			$buttonState = "disabled";
		}
		$smarty->assign("name", $name);
		$smarty->assign('email', $email);
		$smarty->assign("admin", $admin);
		$smarty->assign("buttonState", $buttonState);
		$template = 'settings.tpl';
	} else {
		$template = 'home.tpl';
	}
} else {
	$name = "";
	$login_or_logout = "Login";
	$login_or_logout_link = "./?login";
	$settings = "./?settings";
	$template = 'notloggedIn.tpl';
}


if (isset($_GET["home"])) {
	$template = 'home.tpl';
} elseif (isset($_GET["login"]) && !$login->isUserLoggedIn()) {
	$template = 'notloggedIn.tpl';
} elseif (empty($_GET)) {
	$template = 'home.tpl';
}

$smarty->assign("token", $reset->getToken());
$smarty->assign('csrfToken', $_SESSION["csrfToken"]);
$smarty->assign("name", $name);
$smarty->assign("login_or_logout", $login_or_logout);
$smarty->assign("login_or_logout_link", $login_or_logout_link);
$smarty->assign("settings", $settings);


$smarty->display($template);
