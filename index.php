<?php

#ini_set('display_errors', 'Off');
session_cache_limiter(false);

require_once('./vendor/autoload.php');
require_once("/home/config.php");
require_once("./klassen/Logs.inc.php");

require_once("./klassen/db/DBHelper.inc.php");
require_once("./klassen/db/DBUser.inc.php");
require_once("./klassen/db/DBNews.inc.php");
require_once("./klassen/db/DBBewertung.inc.php");
require_once("./klassen/db/DBLoginlogs.inc.php");

require_once("./klassen/Security.inc.php");
require_once("./klassen/Login.inc.php");
require_once('./klassen/Mail.inc.php');
require_once("./klassen/Register.inc.php");
require_once("./klassen/Reset.inc.php");
require_once("./klassen/Request.inc.php");
require_once("./klassen/Settings.inc.php");
require_once("./klassen/News.inc.php");

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});


//POST oder GET ?
$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
//Datenbank verbindung herstellen
$link = DBHelper::connectWithDatabase();


//überprüft ob zu viele Loginversuche stattgefunden haben pro ip
$security = new Security($link);
//session wird in login erzeugt bzw wiederaufgenommen falls vorhanden
$login = new Login($link, $security);
//registrierungs logik
$register = new Register($link);
//password reset logik
$reset = new Reset($link, $security);
//Benutzer Rolle ändern
$settings = new Settings($link, $login);
//News holen, mit chat übersetzen und in db abspeichern
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
    //news bzw favoriten seite vorbereiten
    if (isset($_GET["news"]) || isset($_GET["favoriten"])) {
        //news Artikel
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $newsArticle = DBNews::getNewsArticleDb($link, DBHelper::escape($link, $_GET["id"]));
            if ($newsArticle != null) {
                $liked = DBBewertung::checkLike($link, DBHelper::escape($link, $_GET["id"]));
                $likes = DBBewertung::countLikes($link, DBHelper::escape($link, $_GET["id"]));
                $smarty->assign('newsArticle', $newsArticle);
                $smarty->assign('liked', $liked);
                $smarty->assign('likes', $likes);
                $template = 'newsarticle.tpl';
            } else {
                //wenn es abgefragte news nicht gibt, weil beispiel falsche id manuel in browser eingegeben wird,
                //dann news Feed anzeigen, neuste 100 holen
                $newsArray = DBNews::getNewsDb($link);
                $smarty->assign('news', $newsArray);
                $template = 'news.tpl';
            }
        } else {
            //news feed bzw favoriten feed

            //Bei langen Ladezeiten kann Anfrage über js bzw js->php->db->js erfolgen, damit loading circle solange angezeigt wird, bis die Daten da sind.

            if (isset($_GET["favoriten"])) {
                //alle damit dann gleich nach gelikten gefiltert werden kann
                $newsArray = DBNews::getAllNewsDb($link);
            } else {
                //news Feed anzeigen, neuste 100 holen
                $newsArray = DBNews::getNewsDb($link);
            }
            //likes <-> benutzter abhängigkeiten holen
            $allLikes = DBNews::getAllLikesDb($link);
            //anzahl an likes für jede news hinzufügen
            //und
            //
            //gucken ob aktueller user news geliked hat
            $user_id = DbUser::getIdByName($link, $name);

            foreach ($newsArray as $key => $news) {
                $newsArray[$key]["likes"] = 0;
                $newsArray[$key]["liked"] = false;
                foreach ($allLikes as $like) {
                    //Anzahl an likes für jede news hinzufügen 
                    if ($news["id"] == $like["news_id"]) {
                        $newsArray[$key]["likes"]++;
                    }
                    //gucken ob aktueller user news geliked hat
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
            // irgendein datum in der vergangenheit
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            // last modified header auf aktuelles datum und uhrzeit setzen
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            // HTTP/1.1
            header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
            // HTTP/1.0
            header("Pragma: no-cache");

            $smarty->assign('news', $newsArray);
            $template = 'news.tpl';
        }
    } elseif (isset($_GET["settings"])) {
        //damit bei einstellungen alle benutzer angezeigt werden für die admins
        $alleBenutzer = DBUser::getUsers($link);

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
} elseif (empty($_GET)) {
    header("Location: " . "?news");
}


//error bzw messages anzeigen
if (Logs::getFirstError() != null) {
    $smarty->assign('errors', Logs::getFirstError());
}
if (Logs::getFirstMessage() != null) {
    $smarty->assign('messages', Logs::getFirstMessage());
}


$smarty->assign("token", $reset->getToken());
$smarty->assign('csrfToken', $_SESSION["csrfToken"]);
$smarty->assign("name", $name);
$smarty->assign("login_or_logout", $login_or_logout);
$smarty->assign("login_or_logout_link", $login_or_logout_link);
$smarty->assign("settings", $settings);


$smarty->display($template);
