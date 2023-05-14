<?php

session_cache_limiter(false);

require_once('./vendor/autoload.php');
require_once("./config.php");
require_once("./includes/startTemplate.inc.php");
require_once("./klassen/Logs.inc.php");
require_once("./klassen/DbFunctions.inc.php");
require_once("./klassen/Security.inc.php");
require_once("./klassen/Login.inc.php");
require_once('./klassen/Mail.inc.php');
require_once("./klassen/Register.inc.php");
require_once("./klassen/Reset.inc.php");
require_once("./klassen/Request.inc.php");
require_once("./klassen/Settings.inc.php");
require_once("./klassen/News.inc.php");

//Moin oder wad

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
$link = DbFunctions::connectWithDatabase();

//session wird in login erzeugt bzw wiederaufgenommen
//die komplette Login logik inklusive register und password reset wird mittels folgender drei klassen erledigt
$security = new Security($link);
$login = new Login($link, $security);
$register = new Register($link);
$reset = new Reset($link, $security);
$settings = new Settings($link, $login);

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

//route logik
if ($login->isUserLoggedIn()) {
	$name = $_SESSION["name"];
	$login_or_logout = "Logout";
	$login_or_logout_link = "./?logout";
	$settings = "./?settings";
	if (isset($_GET["news"]) || isset($_GET["favoriten"])) {
		if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
			//einzelne news
			$newsArticle = DbFunctions::getNewsArticleDb($link, Dbfunctions::escape($link, $_GET["id"]));
			if ($newsArticle != null) {
				$liked = DbFunctions::checkLike($link, Dbfunctions::escape($link, $_GET["id"]));
				$likes = DbFunctions::countLikes($link, Dbfunctions::escape($link, $_GET["id"]));
				$smarty->assign('newsArticle', $newsArticle);
				$smarty->assign('liked', $liked);
				$smarty->assign('likes', $likes);
				$template = 'newsarticle.tpl';
			} else {
				$newsArray = DbFunctions::getNewsDb($link);
				$smarty->assign('news', $newsArray);
				$template = 'news.tpl';
			}
		} else {
			//news feed bzw favoriten

			//Bei langen Ladezeiten kann Anfrage über js bzw js->php->db->js erfolgen, damit loading circle solange angezeigt wird, bis die Daten da sind.
			$newsArray = DbFunctions::getNewsDb($link);
			$allLikes = DbFunctions::getAllLikesDb($link);
			//anzahl an likes für jede news hinzufügen
			//und
			//
			//gucken ob aktueller user news geliked hat
			$user_id = DbFunctions::getIdByName($link, $name);

			foreach ($newsArray as $key => $news) {
				$newsArray[$key]["likes"] = 0;
				$newsArray[$key]["liked"] = false;
				foreach ($allLikes as $like) {
					if ($news["id"] == $like["news_id"]) {
						$newsArray[$key]["likes"]++;
					}
					if ($newsArray[$key]["liked"] == false && $news["id"] == $like["news_id"] && $like["benutzter_id"] == $user_id) {
						$newsArray[$key]["liked"] = true;
					}
				}
				//wenn favoriten seite, nur die geliketen anzeigen
				if (isset($_GET["favoriten"]) && $newsArray[$key]["liked"] == false) {
					unset($newsArray[$key]);
				}
			}

			if (empty($newsArray)) {
				if (isset($_GET["news"])) {
					Logs::addMessage("Keine News vorhanden.");
				} else if (isset($_GET["favoriten"])) {
					Logs::addMessage("Du hast keine Favoriten, da du noch nichts geliked hast.");
				}
			}


			//folgendes damit newsfeed immer neu geladen wird. Wenn man beispielsweise bei einem artikel auf den zurück button klickt, wird newsfeed nicht aus cash genommen sondern neu geladen.
			//nötig, damit like aktualisiert wird
			// any valid date in the past
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			// always modified right now
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			// HTTP/1.1
			header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
			// HTTP/1.0
			header("Pragma: no-cache");

			$smarty->assign('news', $newsArray);
			$template = 'news.tpl';
		}
	} elseif (isset($_GET["settings"])) {
		$alleBenutzer = DbFunctions::getUsers($link);

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
		$smarty->assign("alleBenutzer", $alleBenutzer);
		$template = 'settings.tpl';
	} else {
		$template = 'home.tpl';
	}
} else {
	$name = "";
	$login_or_logout = "Login";
	$login_or_logout_link = "./?login";
	$settings = "./?settings";
	$template = 'notloggedin.tpl';
}


if (isset($_GET["home"])) {
	$template = 'home.tpl';
} elseif (isset($_GET["login"]) && !$login->isUserLoggedIn()) {
	$template = 'notloggedin.tpl';
} elseif (empty($_GET)) {
	$template = 'home.tpl';
}


//error bzw messages anzeigen
if (Logs::getErrors() != null) {
	$smarty->assign('errors', Logs::getErrors());
} else if (Logs::getMessages() != null) {
	$smarty->assign('messages', Logs::getMessages());
}


$smarty->assign("token", $reset->getToken());
$smarty->assign('csrfToken', $_SESSION["csrfToken"]);
$smarty->assign("name", $name);
$smarty->assign("login_or_logout", $login_or_logout);
$smarty->assign("login_or_logout_link", $login_or_logout_link);
$smarty->assign("settings", $settings);


$smarty->display($template);

//ab hier folgt service worker bzw. für PWA
