<?php


class Register
{

    private $link = null;


    public function __construct($link)
    {

        $this->link = $link;
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        } else if (isset($_GET["token"]) && isset($_GET["confirm"])) {
            $this->confirmNewUser();
        }
    }

    private function confirmNewUser()
    {
        $token = DBHelper::escape($this->link, $_GET['token']);
        $erfolg = DBUser::activateAccount($this->link, $token);
        if ($erfolg) {
            Logs::addMessage("Dein Konto wurde erfolgreich aktiviert! Logge dich jetzt ein.");
        } else {
            Logs::addError("Dein Konto konnte nicht aktiviert werden.");
        }
    }

    private function registerNewUser()
    {
        if (strlen($_POST['password']) < 8) {
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
        } elseif (empty($_POST['password']) || empty($_POST['password_repeat'])) {
            Logs::addError("Beide Passwörter müssen ausgefüllt werden");
        } elseif ($_POST['password'] !== $_POST['password_repeat']) {
            Logs::addError("Die Passwörter stimmen nicht überein");
        } elseif (empty($_POST['username'])) {
            Logs::addError("Benutztername ist leer");
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
        } else {
            if (!$this->link->set_charset("utf8")) {
                Logs::addError($this->link->error);
            }

            if (!$this->link->connect_errno) {

                $username = DBHelper::escape($this->link, $_POST['username']);
                $email = DBHelper::escape($this->link, $_POST['email']);
                $password = DBHelper::escape($this->link, $_POST['password']);

                $password_hash = password_hash($password, PASSWORD_ARGON2ID);

                $result_of_login_check = DBUser::exists2($this->link, $username, $email);

                if ($result_of_login_check->num_rows == 1) {
                    Logs::addError("Der Benutzername/E-Mail-Adresse ist bereits vergeben");
                } else {

                    $token = bin2hex(openssl_random_pseudo_bytes(32));

                    $zustand = Mail::sendMailRegister($username, $email, $token);

                    if ($zustand) {
                        //deaktivierten account anlegen
                        DBUser::createAccount($this->link, $username, $email, $password_hash, $token);
                        Logs::addMessage("Es wurde eine Bestätigungsmail an deine Email Adresse gesendet. Bitte aktiviere mit dieser Mail deinen Account.");
                    } else {
                        Logs::addMessage("Registrierung fehlgeschlagen (Es konnte keine Mail an deine Mailadresse gesendet werden.)");
                    }
                }
            } else {
                Logs::addError("Es besteht keine Verbindung zur Datenbank");
            }
        }
    }
}
