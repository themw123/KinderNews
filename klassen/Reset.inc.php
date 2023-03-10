<?php


class Reset
{

    private $link = null;
    private $token = null;

    public function __construct($link)
    {
        $this->link = $link;
        if (isset($_POST["resetMail"])) {
            $this->sendPasswordResetMail();
        } else if (isset($_POST["resetPassword"])) {
            $this->resetPassword();
        } else if (isset($_GET["resetPassword"])) {
            $this->setToken();
        }
    }


    private function setToken()
    {
        $this->token = $this->link->real_escape_string(strip_tags($_GET['token'], ENT_QUOTES));
    }

    public function getToken()
    {
        return $this->token;
    }


    private function resetPassword()
    {
        $token = $this->link->real_escape_string(strip_tags($_POST['token'], ENT_QUOTES));
        $password = $this->link->real_escape_string(strip_tags($_POST['password'], ENT_QUOTES));
        $password_repeat = $this->link->real_escape_string(strip_tags($_POST['password_repeat'], ENT_QUOTES));
        if ($password == $password_repeat) {
            $password_hash = password_hash($password, PASSWORD_ARGON2ID);
            $erfolg = DbFunctions::resetPassword($this->link, $password_hash, $token);
            if ($erfolg) {
                Logs::addMessage("Dein Passwort wurde erfolgreich geändert! Logge dich jetzt ein.");
            } else {
                Logs::addError("Dein Passwort konnte nicht geändert werden.");
            }
        } else {
            Logs::addError("Deine Passwörter stimmen nicht überein.");
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

                $result_of_login_check = DbFunctions::exists1($this->link, $email);



                if ($result_of_login_check->num_rows == 0) {
                    Logs::addError("Die E-Mail-Adresse existiert nicht");
                } else {

                    $token = bin2hex(openssl_random_pseudo_bytes(32));

                    $zustand = Mail::sendMailReset($email, $token);

                    if ($zustand) {

                        //Token dem Benutzer hinzufügen
                        DbFunctions::setToken($this->link, $email, $token);


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
