<?php


class Register
{

    private $link = null;


    public function __construct($link)
    {

        $this->link = $link;
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        } else if (isset($_GET["confirm"])) {
            $this->confirmNewUser();
        }
    }

    private function confirmNewUser()
    {
        $token = $_GET['token'];
        $erfolg = DbFunctions::activateAccount($this->link, $token);
        if ($erfolg) {
            Logs::addMessage("Dein Konto wurde erfolgreich aktiviert! Logge dich jetzt ein.");
        } else {
            Logs::addError("Dein Konto konnte nicht aktiviert werden.");
        }
    }

    private function registerNewUser()
    {
        if (empty($_POST['username'])) {
            Logs::addError("Benutztername ist leer");
        } elseif (empty($_POST['password']) || empty($_POST['password_repeat'])) {
            Logs::addError("Beide Passwörter müssen ausgefüllt werden");
        } elseif ($_POST['password'] !== $_POST['password_repeat']) {
            Logs::addError("Die Passwörter stimmen nicht überein");
        } elseif (strlen($_POST['password']) < 6) {
            Logs::addError("Passwort muss mindestens 6 Zeichen lang sein");
        } elseif (strlen($_POST['username']) > 64 || strlen($_POST['username']) < 2) {
            Logs::addError("Benutzername muss zwischen 2 und 62 Zeichen lang sein");
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])) {
            Logs::addError("Benutzername stimmt nicht mit den erlaubten Zeichen überein: a-Z und 2 bis 64");
        } elseif (empty($_POST['email'])) {
            Logs::addError("E-Mail-Feld kann nicht leer sein");
        } elseif (strlen($_POST['email']) > 64) {
            Logs::addError("Email-Adresse darf nicht mehr als 62 Zeichen beinhalten");
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            Logs::addError("Deine E-Mail-Adresse entspricht nicht den erlaubten Zeichen");
        } elseif (
            !empty($_POST['username'])
            && strlen($_POST['username']) <= 64
            && strlen($_POST['username']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])
            && !empty($_POST['email'])
            && strlen($_POST['email']) <= 64
            && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['password'])
            && !empty($_POST['password_repeat'])
            && ($_POST['password'] === $_POST['password_repeat'])
        ) {
            if (!$this->link->set_charset("utf8")) {
                Logs::addError($this->link->error);
            }

            if (!$this->link->connect_errno) {

                $username = $this->link->real_escape_string(strip_tags($_POST['username'], ENT_QUOTES));
                $email = $this->link->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
                $password = $this->link->real_escape_string(strip_tags($_POST['password'], ENT_QUOTES));

                $password_hash = password_hash($password, PASSWORD_ARGON2ID);

                $result_of_login_check = DbFunctions::exists2($this->link, $username, $email);

                if ($result_of_login_check->num_rows == 1) {
                    Logs::addError("Der Benutzername/E-Mail-Adresse ist bereits vergeben");
                } else {

                    $token = bin2hex(openssl_random_pseudo_bytes(32));

                    $zustand = Mail::sendMailRegister($username, $email, $token);

                    if ($zustand) {
                        //deaktivierten account anlegen
                        DbFunctions::createAccount($this->link, $username, $email, $password_hash, $token);
                        Logs::addMessage("Es wurde eine Bestätigungsmail an deine Email Adresse gesendet. Bitte aktiviere mit dieser Mail deinen Account.");
                    } else {
                        Logs::addMessage("Registrierung fehlgeschlagen (Es konnte keine Mail an deine Mailadresse gesendet werden.)");
                    }
                }
            } else {
                Logs::addError("Es besteht keine Verbindung zur Datenbank");
            }
        } else {
            Logs::addError("Ein unbekannter Fehler ist aufgetreten.");
        }
    }
}
