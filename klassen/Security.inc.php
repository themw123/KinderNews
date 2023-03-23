<?php

class Security
{
    private $link;
    private $ip_address;
    private $count;

    private $timeout;
    private $attemps;

    public function __construct($link)
    {
        $this->link = $link;
        $this->timeout = 60;
        $this->attemps = 2;
    }

    public function checkLoginAttempts()
    {

        $this->ip_address = $this->getIpAddr();
        $text = $this->timeout;

        //wenn mehr als 5
        $count_all = Dbfunctions::getLoginAttemptsAll($this->link, $this->ip_address);

        if ($count_all >= $this->attemps) {
            //wenn mehr als ein über erlaubte versuche
            if ($count_all == $this->attemps + 1) {
                //2 Minuten
                $this->timeout = $this->timeout * 2;
            } else if ($count_all == $this->attemps + 2) {
                //5 Minuten
                $this->timeout = $this->timeout * 5;
            } else if ($count_all == $this->attemps + 2) {
                //1 Tag
                //ab hier an immer nur 1 Versuch pro Tag bis Passwort richtig eingegeben wurde
                //selbst bei einem 6 stelligen lowercase passwort ohne Zahlen und Sonderzeichen würde es 846344 Jahre dauern alle Kombinationen durchzuprobieren.
                $this->timeout = $this->timeout * 1440;
            }
        }

        if ($count_all > $this->attemps) {
            $text = $this->timeout;
        }

        $time = time() - $this->timeout; //wenn in den letzten x sekunden eingeloggt wurde
        $this->count = Dbfunctions::getLoginAttempts($this->link, $time, $this->ip_address);

        //bei mehr als 5 versuchen nur noch 1 versuch bis nächste Stufe
        if ($count_all >= $this->attemps) {
            $this->attemps = 1;
        }

        if ($this->count >= $this->attemps) {
            Logs::addError("zu viele Login Versuche. Bitte warte $text Sekunden");
            return false;
        } else {
            return true;
        }
    }

    public function setLoginAttempts()
    {
        $time = time();
        DbFunctions::setLoginAttempts($this->link, $time, $this->ip_address);
    }

    public function deleteLoginAttempts()
    {
        Dbfunctions::deleteLoginAttempts($this->link, $this->ip_address);
    }

    private function getIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //geteilte internet verbindung
            $ipAddr = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //proxy
            $ipAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ipAddr = $_SERVER['REMOTE_ADDR'];
        }
        //entfernen von ungewollten leerzeichen und zeichen
        $ipAddr = preg_replace('/[^0-9a-fA-F:\.,]/', '', $ipAddr);

        return $ipAddr;
    }

    public function checkTokenTime($token)
    {
        $now = time();
        $stored_time = DbFunctions::getTokenTime($this->link, $token);
        if ($stored_time == null) {
            return false;
        }
        $diff = $now - $stored_time;
        if ($diff <= 600) {
            //höchstens 10 Minuten drüber
            return true;
        } else {
            //mehr als 10 Minuten drüber
            return false;
        }
    }
}
