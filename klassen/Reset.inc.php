<?php


class Reset
{

    private $link = null;
    private $security;
    private $token = "";

    public function __construct($link, $security)
    {
        $this->link = $link;
        $this->security = $security;
        if (isset($_POST["resetMail"])) {
            //mail versenden, mit der der benutzer dann sein passwort zurücksetzen kann
            $this->sendPasswordResetMail();
        } else if (isset($_POST["resetPassword"])) {
            //passwort in db zurücksetzen
            $this->resetPassword();
        } else if (isset($_GET["resetPassword"])) {
            //token aus url holen
            if (isset($_GET["token"]) && isset($_GET["resetPassword"])) {
                $this->setToken();
            }
        }
    }


    private function setToken()
    {
        $this->token = DBHelper::escape($this->link, $_GET['token']);
    }

    public function getToken()
    {
        return $this->token;
    }


    private function resetPassword()
    {
        $token = DBHelper::escape($this->link, $_POST['token']);
        $password = DBHelper::escape($this->link, $_POST['password']);
        $password_repeat = DBHelper::escape($this->link, $_POST['password_repeat']);
        if ($password != $password_repeat) {
            Logs::addError("Deine Passwörter stimmen nicht überein.");
        } else if (strlen($_POST['password']) < 8) {
            Logs::addError("Passwort muss mindestens 8 Zeichen lang sein");
        }
        // Überprüfe auf Großbuchstaben
        elseif (!preg_match('/[A-Z]/', $_POST['password'])) {
            Logs::addError("Password enthält keine Großbuchstaben");
        }
        // Überprüfe auf Kleinbuchstaben
        elseif (!preg_match('/[a-z]/', $_POST['password'])) {
            Logs::addError("Password enthält keine Kleinbuchstaben");
        }
        // Überprüfe auf Zahlen
        elseif (!preg_match('/[0-9]/', $_POST['password'])) {
            Logs::addError("Password enthält keine Zahlen");
        }
        // Überprüfe auf Sonderzeichen
        elseif (!preg_match('/.*\W+/', $_POST['password'])) {
            Logs::addError("Password enthält keine Sonderzeichen");
        } else if ($token != null && !($this->security->checkTokenTime($token))) {
            Logs::addError("Das Token ist falsch oder abgelaufen, bitte fordere eine neue Mail zum zurücksetzten deines Passwortes an.");
            return;
        } else {
            //passwort verschlüsseln
            $password_hash = password_hash($password, PASSWORD_ARGON2ID);
            //passwort in db ändern
            $erfolg = DBUser::resetPassword($this->link, $password_hash, $token);
            if ($erfolg) {
                Logs::addMessage("Dein Passwort wurde erfolgreich geändert! Logge dich jetzt ein.");
            } else {
                Logs::addError("Es ist etwas schief gegangen.");
            }
        }
    }

    private function sendPasswordResetMail()
    {

        if (empty($_POST['email'])) {
            Logs::addError("Benutzername bzw. Email darf nicht leer sein");
        } else {

            if (!$this->link->set_charset("utf8")) {
                Logs::addError($this->link->error);
            }

            if (!$this->link->connect_errno) {

                $email = $this->link->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));

                //gucken ob email oder name existiert und ob der account aktiviert ist
                $result_of_login_check = DBUser::exists1($this->link, $email);


                if ($result_of_login_check->num_rows == 0) {
                    Logs::addError("Die E-Mail-Adresse existiert nicht");
                } else {
                    //token generieren um account danach zu aktivieren
                    $token = bin2hex(openssl_random_pseudo_bytes(32));

                    //mail versenden fürs zurücksetzten des passwortes
                    $zustand = Mail::sendMailReset($email, $token);

                    if ($zustand) {
                        $time = time();
                        //Token und Uhrzeit dem Benutzer hinzufügen in db
                        DBUser::setToken($this->link, $email, $token, $time);

                        Logs::addMessage("Es wurde eine Mail zum zurücksetzten deines Passwortes an deine Email Adresse gesendet.");
                    } else {
                        Logs::addError("Mail senden fehlgeschlagen");
                    }
                }
            } else {
                Logs::addError("Es besteht keine Verbindung zur Datenbank");
            }
        }
    }
}
