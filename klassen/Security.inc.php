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
        $this->attemps = 3;
    }

    public function checkLoginAttempts()
    {
        //ip adresse holen
        $this->ip_address = $this->getIpAddr();
        $text = $this->timeout;

        //wenn mehr als 3 fehlversuche
        $count_all = DBLoginLogs::getLoginAttemptsAll($this->link, $this->ip_address);

        //Zu viele fehlversuche
        if ($count_all >= $this->attemps) {
            //wenn mehr als ein über erlaubte versuche
            if ($count_all == $this->attemps + 1) {
                //2 Minuten warten
                $this->timeout = $this->timeout * 2;
            } else if ($count_all == $this->attemps + 2) {
                //5 Minuten warten
                $this->timeout = $this->timeout * 5;
            } else if ($count_all == $this->attemps + 3) {
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
        //wie viele fehlversuche bezüglich des logins wurden von einer ip innerhalb der gegebenen Zeit getätigt?
        $this->count = DBLoginLogs::getLoginAttempts($this->link, $time, $this->ip_address);

        //bei mehr als 3 versuchen nur noch 1 versuch bis nächste Stufe
        if ($count_all >= $this->attemps) {
            $this->attemps = 1;
        }

        if ($this->count >= $this->attemps) {
            Logs::addError("Zu viele Login Versuche. Bitte warte $text Sekunden.");
            return false;
        } else {
            return true;
        }
    }

    public function setLoginAttempts()
    {
        //aktuelle Zeit
        $time = time();
        DBLoginLogs::setLoginAttempts($this->link, $time, $this->ip_address);
    }

    public function deleteLoginAttempts()
    {
        DBLoginLogs::deleteLoginAttempts($this->link, $this->ip_address);
    }

    private function getIpAddr()
    {
        $ipAddr = $_SERVER['REMOTE_ADDR'];
        //entfernen von ungewollten leerzeichen und zeichen
        $ipAddr = preg_replace('/[^0-9a-fA-F:\.,]/', '', $ipAddr);

        return $ipAddr;
    }

    public function checkTokenTime($token)
    {
        $now = time();
        $stored_time = DBUser::getTokenTime($this->link, $token);
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
