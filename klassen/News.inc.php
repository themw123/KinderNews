<?php
//damit script nicht abgebrochen wird wenn request länger dauert. Ungefähr 8 minuten jetzt möglich, gebraucht werden so 3 Minuten.
set_time_limit(500);

class News
{

    private $link = null;
    private $login = null;

    public function __construct($link, $login)
    {
        $this->link = $link;
        $this->login = $login;


        //Production code!!!!
        if ($this->login->isUserAdmin() && isset($_GET["getNews"])) {
            shell_exec("/usr/local/bin/php /backend/index.php > /dev/null 2>/dev/null &");
            Logs::cloudflare();
        }
        if ($this->login->isUserLoggedIn()) {
            if (isset($_GET["like"]) && $_GET["like"] == "like") {
                DBBewertung::like($link, DBHelper::escape($link, $_GET["id"]));
                die();
            } else if (isset($_GET["like"]) && $_GET["like"] == "removeLike") {
                DBBewertung::removeLike($link, DBHelper::escape($link, $_GET["id"]));
                die();
            }
        }
    }
}
