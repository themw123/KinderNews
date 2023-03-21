<?php
//damit script nicht abgebrochen wird wenn request länger dauert. Ungefähr 8 minuten jetzt möglich, gebraucht werden so 3 Minuten.
set_time_limit(500);

class News
{

    private $link = null;
    private $login = null;

    public function __construct($link, $login)
    {
        $this->login = $login;


        //Production code!!!!
        if ($this->login->isUserAdmin() && isset($_GET["getNews"])) {
            shell_exec("/usr/local/bin/php /home/index.php &");
            Logs::cloudflare();
        }
    }
}
