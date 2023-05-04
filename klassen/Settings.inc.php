<?php

class Settings
{

    private $link = null;
    private $login = null;

    public function __construct($link, $login)
    {
        $this->link = $link;
        $this->login = $login;

        if (isset($_POST["id"]) && isset($_POST["admin"])) {
            if ($this->login->isUserKindernews() && DbFunctions::getNameById($link, Dbfunctions::escape($link, $_POST["id"])) != "kindernews") {
                DbFunctions::changeRole($link, Dbfunctions::escape($link, $_POST["id"]), Dbfunctions::escape($link, $_POST["admin"]));
                die();
            }
        }
    }
}
