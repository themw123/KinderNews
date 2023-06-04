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
            if ($this->login->isUserKindernews() && DBUser::getNameById($link, DBHelper::escape($link, $_POST["id"])) != "kindernews") {
                DBUser::changeRole($link, DBHelper::escape($link, $_POST["id"]), DBHelper::escape($link, $_POST["admin"]));
                die();
            }
        }
    }
}
