<?php

class DBLoginlogs
{

    public static function getLoginAttemptsAll($link, $ip_address)
    {
        //wie viele fehlversuche bezüglich des logins wurden von einer ip getätigt?
        $stmt = $link->prepare(
            "select count(*) as count from loginlogs where ipadresse= ?"
        );
        $stmt->bind_param("s", $ip_address);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_assoc()["count"];
        return $count;
    }

    public static function getLoginAttempts($link, $time, $ip_address)
    {
        //wie viele fehlversuche bezüglich des logins wurden von einer ip innerhalb der gegebenen Zeit getätigt?
        $stmt = $link->prepare(
            "select count(*) as count from loginlogs where uhrzeit > ? and ipadresse= ?"
        );
        $stmt->bind_param("ss", $time, $ip_address);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_assoc()["count"];
        return $count;
    }

    public static function setLoginAttempts($link, $time, $ip_address)
    {
        //fehlversuch abspeichern
        $stmt = $link->prepare(
            "insert into loginlogs(ipadresse,uhrzeit) values(?,?)"
        );
        $stmt->bind_param("ss", $ip_address, $time);
        $stmt->execute();
        //$count = $stmt->get_result()->fetch_assoc()[""];
        //return $count;
    }

    public static function deleteLoginAttempts($link, $ip_address)
    {
        //bei korrektem login alle fehlversuche dieser ip löschen
        $stmt = $link->prepare(
            "delete from loginlogs where ipadresse=?"
        );
        $stmt->bind_param("s", $ip_address);
        $stmt->execute();
        //$count = $stmt->get_result()->fetch_assoc()[""];
        //return $count;
    }
}
